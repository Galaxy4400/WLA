/**
* @license Copyright (c) 2014-2023, CKSource Holding sp. z o.o. All rights reserved.
* For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
import { ClassicEditor } from '@ckeditor/ckeditor5-editor-classic';
import { Alignment } from '@ckeditor/ckeditor5-alignment';
import { Bold, Italic, Strikethrough, Subscript, Superscript, Underline } from '@ckeditor/ckeditor5-basic-styles';
import { BlockQuote } from '@ckeditor/ckeditor5-block-quote';
import { Essentials } from '@ckeditor/ckeditor5-essentials';
import { FontColor } from '@ckeditor/ckeditor5-font';
import { HorizontalLine } from '@ckeditor/ckeditor5-horizontal-line';
import { AutoImage, Image, ImageCaption, ImageInsert, ImageResize, ImageStyle, ImageToolbar, ImageUpload } from '@ckeditor/ckeditor5-image';
import { Indent, IndentBlock } from '@ckeditor/ckeditor5-indent';
import { Link, LinkImage } from '@ckeditor/ckeditor5-link';
import { DocumentList, DocumentListProperties } from '@ckeditor/ckeditor5-list';
import { MediaEmbed, MediaEmbedToolbar } from '@ckeditor/ckeditor5-media-embed';
import { Paragraph } from '@ckeditor/ckeditor5-paragraph';
import { ShowBlocks } from '@ckeditor/ckeditor5-show-blocks';
import { SourceEditing } from '@ckeditor/ckeditor5-source-editing';
import { Table, TableCaption, TableCellProperties, TableColumnResize, TableProperties, TableToolbar } from '@ckeditor/ckeditor5-table';

declare class Editor extends ClassicEditor {
	static builtinPlugins: (
		typeof Alignment |
		typeof AutoImage |
		typeof BlockQuote |
		typeof Bold |
		typeof DocumentList |
		typeof DocumentListProperties |
		typeof Essentials |
		typeof FontColor |
		typeof HorizontalLine |
		typeof Image |
		typeof ImageCaption |
		typeof ImageInsert |
		typeof ImageResize |
		typeof ImageStyle |
		typeof ImageToolbar |
		typeof ImageUpload |
		typeof Indent |
		typeof IndentBlock |
		typeof Italic |
		typeof Link |
		typeof LinkImage |
		typeof MediaEmbed |
		typeof MediaEmbedToolbar |
		typeof Paragraph |
		typeof ShowBlocks |
		typeof SourceEditing |
		typeof Strikethrough |
		typeof Subscript |
		typeof Superscript |
		typeof Table |
		typeof TableCaption |
		typeof TableCellProperties |
		typeof TableColumnResize |
		typeof TableProperties |
		typeof TableToolbar |
		typeof Underline
	)[];

	static defaultConfig: {
		toolbar: {
			items: string[];
		};
		language: string;
		image: {
			toolbar: string[];
		};
		table: {
			contentToolbar: string[];
		};
	};
}

export default Editor;
