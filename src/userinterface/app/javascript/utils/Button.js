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

    }

};
