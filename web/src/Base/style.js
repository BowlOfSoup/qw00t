import React, {StyleSheet, Dimensions, PixelRatio} from "react-native";
const {width, height, scale} = Dimensions.get("window"),
    vw = width / 100,
    vh = height / 100,
    vmin = Math.min(vw, vh),
    vmax = Math.max(vw, vh);

export default StyleSheet.create({
    "html": {
        "overflowY": "scroll"
    },
    "body": {
        "color": "#5687A3"
    },
    "header": {
        "backgroundColor": "#d0ac92"
    },
    "content": {
        "marginTop": 10
    },
    "app-logo": {
        "width": 300
    },
    "content-align-right": {
        "textAlign": "right"
    },
    "content-align-center": {
        "textAlign": "center",
        "marginTop": 20
    },
    "quote-wrapper": {
        "marginBottom": 40
    },
    "quote-context": {
        "paddingTop": 5,
        "paddingRight": 0,
        "paddingBottom": 5,
        "paddingLeft": 0
    },
    "quote-content": {
        "fontSize": 1.5,
        "paddingTop": 0,
        "paddingRight": 10,
        "paddingBottom": 0,
        "paddingLeft": 10
    },
    "quote-person": {
        "paddingTop": 5,
        "paddingRight": 0,
        "paddingBottom": 5,
        "paddingLeft": 0,
        "textAlign": "right"
    },
    "btn-primary": {
        "borderColor": "#5687A3",
        "backgroundColor": "#5687A3",
        "backgroundImage": "none"
    },
    "btn-primary:hover": {
        "backgroundColor": "#d0ac92",
        "borderColor": "#d0ac92",
        "cursor": "pointer"
    },
    "btn-primary:focus": {
        "boxShadow": "none"
    },
    "btn-primaryfocus": {
        "boxShadow": "none"
    }
});