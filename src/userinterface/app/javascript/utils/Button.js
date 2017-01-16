'use strict';

module.exports = {

    loadingClass: 'MimotoCMS_ButtonModule--loading',
    loadingIcon: '#ico-loading',
    loadingIconClass: 'MimotoCMS_ButtonModule-icon--loading',
    successClass: 'MimotoCMS_ButtonModule--success',
    successIcon: '#ico-checkmark',
    successIconClass: 'MimotoCMS_ButtonModule-icon--success',
    iconSelector: '.js-button-icon',

    addLoadingState: function (button) {

        var useElement = button.getElementsByTagName('use')[0];
        var icon = button.querySelector(this.iconSelector);

        button.classList.add(this.loadingClass);
        icon.classList.add(this.loadingIconClass);
        useElement.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', this.loadingIcon);

        this.addIcon(this.loadingIcon);

    },

    removeLoadingState: function (button) {

        var useElement = button.getElementsByTagName('use')[0];
        var icon = button.querySelector(this.iconSelector);
        var originalIcon = button.getAttribute('data-icon');

        button.classList.remove(this.loadingClass);
        icon.classList.remove(this.loadingIconClass);
        useElement.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', originalIcon);

    },

    addSuccessState: function (button) {

        var useElement = button.getElementsByTagName('use')[0];
        var icon = button.querySelector(this.iconSelector);

        button.classList.add(this.successClass);
        icon.classList.add(this.successIconClass);
        useElement.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', this.successIcon);

    },

    removeSuccessState: function (button) {

        var useElement = button.getElementsByTagName('use')[0];
        var icon = button.querySelector(this.iconSelector);
        var originalIcon = button.getAttribute('data-icon');

        button.classList.remove(this.successClass);
        icon.classList.remove(this.successIconClass);
        useElement.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', originalIcon);

    },

    addIcon: function (iconID) {

        var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        var svgns = "http://www.w3.org/2000/svg";
        var xlinkns = "http://www.w3.org/1999/xlink";

        // Create a <use> element
        var  use = document.createElementNS(svgns, 'use');

        // Add an 'href' attribute (using the "xlink" namespace)
        use.setAttributeNS(xlinkns, 'href', iconID);

        svg.appenChild(use);

        console.log(use);

    }

};
