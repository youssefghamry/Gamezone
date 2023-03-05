/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/essgrid/index.js":
/*!******************************!*\
  !*** ./src/essgrid/index.js ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "EssGrid": function() { return /* binding */ EssGrid; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./editor.scss */ "./src/essgrid/editor.scss");



/**
 * Block dependencies
 */

/**
 * Internal block libraries
 */

const {
  __
} = wp.i18n;
const {
  registerBlockType
} = wp.blocks;
const {
  TextControl,
  Button
} = wp.components;
const {
  Component
} = wp.element;
/**
 * essgrid Editor Element
 */

class EssGrid extends Component {
  constructor() {
    super(...arguments);
    const {
      attributes: {
        text,
        gridTitle
      }
    } = this.props;
    this.state = {
      text,
      gridTitle
    };
    window.essgrid_react = {};
  }

  render() {
    const {
      attributes: {
        text,
        gridTitle
      },
      setAttributes
    } = this.props;
    window.essgrid_react = this;

    const openDialog = () => {
      var data = false;
      essgrid_react = this;
      ESG.SC.openBlockSettings({
        editor: 'gutenberg'
      });
    };

    const openEdit = () => {
      window.essgrid_react = this;
      var shortcode = this.state.text,
          attributes = {};
      if (typeof shortcode === "undefined") return false;
      var matches = shortcode.match(/[\w-]+=".+?"/g);
      if (!matches) return false;
      matches.forEach(function (attribute) {
        attribute = attribute.match(/([\w-]+)="(.+?)"/);
        attributes[attribute[1]] = attribute[2];
      });
      if (typeof attributes.alias === "undefined") return false; //  self.location.href =  "admin.php?page=essential-grid&view=grid-create&alias=" + attributes.alias;

      window.open("admin.php?page=essential-grid&view=grid-create&alias=" + encodeURI(attributes.alias), '_blank');
    };

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "essgrid_block"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", null, this.props.attributes.gridTitle, "\xA0"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(TextControl, {
      className: "grid_slug",
      value: this.props.attributes.text,
      onChange: text => setAttributes({
        text
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Button, {
      isDefault: true,
      onClick: openEdit,
      className: "grid_edit_button editor_icon dashicons dashicons-edit"
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Button, {
      isDefault: true,
      onClick: openDialog,
      className: "grid_edit_button"
    }, __('Select Grid', 'essgrid')));
  }

}
/**
 * Register block
 */

/* harmony default export */ __webpack_exports__["default"] = (registerBlockType('themepunch/essgrid', {
  title: __('Essential Grid', 'essgrid'),
  description: __('Add your Essential Grid', 'essgrid'),
  category: 'common',
  icon: {
    src: 'screenoptions',
    background: '#c90000',
    color: 'white'
  },
  example: {
    attributes: {
      cover: true
    }
  },
  keywords: [__('image', 'essgrid'), __('gallery', 'essgrid'), __('grid', 'essgrid')],
  attributes: {
    text: {
      selector: '.essgrid',
      type: 'string',
      source: 'text'
    },
    gridTitle: {
      selector: '.essgrid',
      type: 'string',
      source: 'attribute',
      attribute: 'data-gridtitle'
    },
    alias: {
      type: 'string'
    },
    cover: {
      default: false
    }
  },
  edit: props => {
    const {
      setAttributes,
      attributes: {
        cover
      }
    } = props;
    return [!cover && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(EssGrid, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
      setAttributes
    }, props))), cover && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("center", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
      src: EssGridOptions.pluginurl + "/admin/includes/gutenberg-blocks/build/images/esg-minigif.gif",
      width: 320,
      height: 180
    }))];
  },
  save: props => {
    const {
      attributes: {
        text,
        gridTitle
      }
    } = props;
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "essgrid",
      "data-gridtitle": gridTitle
    }, text);
  }
}));

/***/ }),

/***/ "./src/wpgallery/index.js":
/*!********************************!*\
  !*** ./src/wpgallery/index.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

// import assign from 'lodash.assign';
const {
  createHigherOrderComponent
} = wp.compose;
const {
  Fragment
} = wp.element;
const {
  PanelBody,
  SelectControl,
  ToggleControl,
  TextControl
} = wp.components;
const {
  addFilter
} = wp.hooks;
const {
  __
} = wp.i18n;
if (typeof wp.blockEditor !== 'undefined') var {
  InspectorControls,
  DimensionControl
} = wp.blockEditor;else var {
  InspectorControls,
  DimensionControl
} = wp.editor; // Enable slider control on the following blocks

const EssGridGalleryAddOnBlocks = ['core/gallery'];
/**
 * Add slider control attribute to block.
 *
 * @param {object} settings Current block settings.
 * @param {string} name Name of block.
 *
 * @returns {object} Modified block settings.
 */

const EssGridGalleryAddOnAddControl = (settings, name) => {
  // Do nothing if it's another block than our defined ones.
  // Or Default Grid is not set.
  if (!EssGridGalleryAddOnBlocks.includes(name)) {
    return settings;
  }

  settings.attributes = jQuery.extend(true, settings.attributes, {
    grid: {
      type: 'string',
      default: EssGridOptions.defGrid
    },
    customsettings: {
      type: 'boolean',
      default: false
    },
    entryskin: {
      tpye: 'string'
    },
    layoutsizing: {
      tpye: 'string'
    },
    gridlayout: {
      tpye: 'string'
    },
    tinyspacings: {
      tpye: 'string',
      default: '5'
    },
    rowsunlimited: {
      type: 'string',
      default: 'on'
    },
    tinyrows: {
      type: 'string',
      default: 3
    },
    gridanimation: {
      type: 'string'
    },
    usespinner: {
      type: 'string'
    }
  });
  return settings;
};

addFilter('blocks.registerBlockType', 'essgrid-gallery-addon-gutenberg-extension/attribute/grid', EssGridGalleryAddOnAddControl);
/**
 * Add Slider Option to Block
 */

const EssGridGalleryAddOn = createHigherOrderComponent(BlockEdit => {
  return props => {
    // Do nothing if it's another block than our defined ones.
    // Or do nothing when EssGrid Default Grid Option is not set
    if (!EssGridGalleryAddOnBlocks.includes(props.name) || EssGridOptions.defGrid == "off" || EssGridOptions.defGrid == "" || !EssGridOptions.defGrid) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(BlockEdit, props);
    }

    const MySnackbarNotice = () => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Snackbar, null, "Post published successfully.");

    const {
      grid,
      entryskin,
      customsettings,
      layoutsizing,
      gridlayout,
      tinyspacings,
      rowsunlimited,
      tinyrows,
      gridanimation,
      usespinner
    } = props.attributes; // add essgrid-gallery-addon-alias prefix class name

    if (grid) {
      props.attributes.className = `essgrid-gallery-${grid}`;
    }

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(BlockEdit, props), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
      title: 'Essential Grid',
      initialOpen: grid
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
      label: __('Select Grid'),
      value: grid,
      options: EssGridOptions.arrGrids,
      onChange: grid => {
        props.setAttributes({
          grid
        });
      }
    }), grid && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
      label: __("Custom Settings"),
      checked: customsettings,
      onChange: customsettings => {
        props.setAttributes({
          customsettings
        });
      }
    }), grid && customsettings && [(0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
      label: __('Grid Skin'),
      value: entryskin,
      options: EssGridOptions.arrSkins,
      onChange: entryskin => {
        props.setAttributes({
          entryskin
        });
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
      label: __('Layout'),
      value: layoutsizing,
      options: [{
        label: __('Boxed'),
        value: 'boxed'
      }, {
        label: __('Fullwidth'),
        value: 'fullwidth'
      }],
      onChange: layoutsizing => {
        props.setAttributes({
          layoutsizing
        });
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
      label: 'Grid Layout',
      value: gridlayout,
      options: [{
        value: 'even',
        label: __('Even')
      }, {
        value: 'masonry',
        label: __('Masonry')
      }, {
        value: 'cobbles',
        label: __('Cobbles')
      }],
      onChange: gridlayout => {
        props.setAttributes({
          gridlayout
        });
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
      label: __("Item Spacing (px)"),
      value: tinyspacings,
      type: "number",
      onChange: tinyspacings => {
        props.setAttributes({
          tinyspacings
        });
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
      label: __('Pagination'),
      value: rowsunlimited,
      options: [{
        value: 'on',
        label: __('Disable')
      }, {
        value: 'off',
        label: __('Enable')
      }],
      onChange: rowsunlimited => {
        props.setAttributes({
          rowsunlimited
        });
      }
    }), props.attributes.rowsunlimited == 'off' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
      label: __("Rows per Page"),
      value: tinyrows,
      type: "number",
      onChange: tinyrows => {
        props.setAttributes({
          tinyrows
        });
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
      label: __('Filter & Page Animation'),
      value: gridanimation,
      options: [{
        value: 'fade',
        label: __('Fade')
      }, {
        value: 'horizontal-slide',
        label: __('Horizontal Slide')
      }, {
        value: 'vertical-slide',
        label: __('Vertical Slide')
      }],
      onChange: gridanimation => {
        props.setAttributes({
          gridanimation
        });
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
      label: __('Choose Spinner'),
      value: usespinner,
      options: [{
        value: '-1',
        label: __('Off')
      }, {
        value: '0',
        label: '0'
      }, {
        value: '1',
        label: '1'
      }, {
        value: '2',
        label: '2'
      }, {
        value: '3',
        label: '3'
      }, {
        value: '4',
        label: '4'
      }, {
        value: '5',
        label: '5'
      }],
      onChange: usespinner => {
        props.setAttributes({
          usespinner
        });
      }
    })])));
  };
}, 'EssGridGalleryAddOn');
addFilter('editor.BlockEdit', 'essgrid-gallery-addon-gutenberg-extension/with-grid-control', EssGridGalleryAddOn);
/**
 * Assign alias to block class name
 *
 * @param {object} saveElementProps Props of save element.
 * @param {Object} blockType Block type information.
 * @param {Object} attributes Attributes of block.
 *
 * @returns {object} Modified props of save element.
 */

const addEssGridExtraProps = (saveElementProps, blockType, attributes) => {
  // Do nothing if it's another block than our defined ones.
  if (!EssGridGalleryAddOnBlocks.includes(blockType.name)) {
    return saveElementProps;
  } //jQuery.extend(true, saveElementProps, { slider: { 'alias': attributes.slider } } );


  return saveElementProps;
};

addFilter('blocks.getSaveContent.extraProps', 'essgrid-gallery-addon-gutenberg-extension/get-save-content/extra-props', addEssGridExtraProps);

/***/ }),

/***/ "./src/essgrid/editor.scss":
/*!*********************************!*\
  !*** ./src/essgrid/editor.scss ***!
  \*********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _extends; }
/* harmony export */ });
function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _essgrid__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./essgrid */ "./src/essgrid/index.js");
/* harmony import */ var _wpgallery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./wpgallery */ "./src/wpgallery/index.js");
/**
 * Gutenberg Blocks
 *
 * All blocks related JavaScript files should be imported here.
 * You can create a new block folder in this dir and include code
 * for that block here as well.
 *
 * All blocks should be included here since this is the file that
 * Webpack is compiling as the input file.
 */


}();
/******/ })()
;
//# sourceMappingURL=index.js.map