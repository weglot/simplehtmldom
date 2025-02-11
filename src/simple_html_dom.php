<?php

/**
 * Website: http://sourceforge.net/projects/simplehtmldom/
 * Acknowledge: Jose Solorzano (https://sourceforge.net/projects/php-html/)
 *
 * Licensed under The MIT License
 * See the LICENSE file in the project root for more information.
 *
 * Authors:
 *   S.C. Chen
 *   John Schlick
 *   Rus Carroll
 *   logmanoriginal
 *
 * Contributors:
 *   Yousuke Kumakura
 *   Vadim Voituk
 *   Antcs
 *
 * Version $Rev$
 */

use simplehtmldom\HtmlNode;

if (defined('WG_DEFAULT_TARGET_CHARSET')) {
	define('simplehtmldom\WG_DEFAULT_TARGET_CHARSET', WG_DEFAULT_TARGET_CHARSET);
}

if (defined('WG_DEFAULT_BR_TEXT')) {
	define('simplehtmldom\WG_DEFAULT_BR_TEXT', WG_DEFAULT_BR_TEXT);
}

if (defined('WG_DEFAULT_SPAN_TEXT')) {
	define('simplehtmldom\WG_DEFAULT_SPAN_TEXT', WG_DEFAULT_SPAN_TEXT);
}

if (defined('WG_MAX_FILE_SIZE')) {
	define('simplehtmldom\WG_MAX_FILE_SIZE', WG_MAX_FILE_SIZE);
}

include_once 'HtmlDocument.php';
include_once 'HtmlNode.php';

if (!defined('WG_DEFAULT_TARGET_CHARSET')) {
	define('WG_DEFAULT_TARGET_CHARSET', \simplehtmldom\WG_DEFAULT_TARGET_CHARSET);
}

if (!defined('WG_DEFAULT_BR_TEXT')) {
	define('WG_DEFAULT_BR_TEXT', \simplehtmldom\WG_DEFAULT_BR_TEXT);
}

if (!defined('WG_DEFAULT_SPAN_TEXT')) {
	define('WG_DEFAULT_SPAN_TEXT', \simplehtmldom\WG_DEFAULT_SPAN_TEXT);
}

if (!defined('WG_MAX_FILE_SIZE')) {
	define('WG_MAX_FILE_SIZE', \simplehtmldom\WG_MAX_FILE_SIZE);
}

const HDOM_TYPE_ELEMENT = HtmlNode::HDOM_TYPE_ELEMENT;
const HDOM_TYPE_COMMENT = HtmlNode::HDOM_TYPE_COMMENT;
const HDOM_TYPE_TEXT = HtmlNode::HDOM_TYPE_TEXT;
const HDOM_TYPE_ROOT = HtmlNode::HDOM_TYPE_ROOT;
const HDOM_TYPE_UNKNOWN = HtmlNode::HDOM_TYPE_UNKNOWN;
const HDOM_QUOTE_DOUBLE = HtmlNode::HDOM_QUOTE_DOUBLE;
const HDOM_QUOTE_SINGLE = HtmlNode::HDOM_QUOTE_SINGLE;
const HDOM_QUOTE_NO = HtmlNode::HDOM_QUOTE_NO;
const HDOM_INFO_BEGIN = HtmlNode::HDOM_INFO_BEGIN;
const HDOM_INFO_END = HtmlNode::HDOM_INFO_END;
const HDOM_INFO_QUOTE = HtmlNode::HDOM_INFO_QUOTE;
const HDOM_INFO_SPACE = HtmlNode::HDOM_INFO_SPACE;
const HDOM_INFO_TEXT = HtmlNode::HDOM_INFO_TEXT;
const HDOM_INFO_INNER = HtmlNode::HDOM_INFO_INNER;
const HDOM_INFO_OUTER = HtmlNode::HDOM_INFO_OUTER;
const HDOM_INFO_ENDSPACE = HtmlNode::HDOM_INFO_ENDSPACE;

const HDOM_SMARTY_AS_TEXT = \simplehtmldom\HDOM_SMARTY_AS_TEXT;

class_alias('\simplehtmldom\HtmlDocument', 'simple_html_dom');
class_alias('\simplehtmldom\HtmlNode', 'simple_html_dom_node');

function file_get_html(
	$url,
	$use_include_path = false,
	$context = null,
	$offset = 0,
	$maxLen = -1,
	$lowercase = true,
	$forceTagsClosed = true,
	$target_charset = WG_DEFAULT_TARGET_CHARSET,
	$stripRN = true,
	$defaultBRText = WG_DEFAULT_BR_TEXT,
	$defaultSpanText = WG_DEFAULT_SPAN_TEXT)
{
	if($maxLen <= 0) { $maxLen = WG_MAX_FILE_SIZE; }

	$dom = new simple_html_dom(
		null,
		$lowercase,
		$forceTagsClosed,
		$target_charset,
		$stripRN,
		$defaultBRText,
		$defaultSpanText
	);

	$contents = file_get_contents(
		$url,
		$use_include_path,
		$context,
		$offset,
		$maxLen + 1 // Load extra byte for limit check
	);

	if (empty($contents) || strlen($contents) > $maxLen) {
		$dom->clear();
		return false;
	}

	return $dom->load($contents, $lowercase, $stripRN);
}

function str_get_html(
	$str,
	$lowercase = true,
	$forceTagsClosed = true,
	$target_charset = WG_DEFAULT_TARGET_CHARSET,
	$stripRN = true,
	$defaultBRText = WG_DEFAULT_BR_TEXT,
	$defaultSpanText = WG_DEFAULT_SPAN_TEXT)
{
	$dom = new simple_html_dom(
		null,
		$lowercase,
		$forceTagsClosed,
		$target_charset,
		$stripRN,
		$defaultBRText,
		$defaultSpanText
	);

	if (empty($str) || strlen($str) > WG_MAX_FILE_SIZE) {
		$dom->clear();
		return false;
	}

	return $dom->load($str, $lowercase, $stripRN);
}

/** @codeCoverageIgnore */
function dump_html_tree($node, $show_attr = true, $deep = 0)
{
	$node->dump($node);
}
