var TheTimeline = function()
{

    // dom
    var _canvas;

    // positioning
    this._nWindowWidth;
    this._nWindowHeight;
    this._nMarginBottom;
    this._nDayWidth = 40;

    // time

    this._nDayInMiliseconds = 24 * 60 * 60 * 1000;


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    this.__construct = function()
    {
        // register
        var classRoot = this;

        this._nDayWidth = 40;
        this._nDayInMiliseconds = 24 * 60 * 60 * 1000;

        window.onload = function()
        {
            // register
            classRoot._canvas = document.getElementById('TheTimeline-canvas');

            // draw
            classRoot._drawTimeline(classRoot._canvas);
            classRoot.positionMoments(classRoot._canvas);
        }

        window.onresize = function()
        {
            // clear
            classRoot._clearTimeline(classRoot._canvas);

            // redraw
            classRoot._drawTimeline(classRoot._canvas);
            classRoot.positionMoments(classRoot._canvas);
        }
    }



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Position moments on timeline
     * @param canvas
     * @param change
     */
    this.positionMoments = function(change)
    {
        console.log('scope this = ', this);

        // 1. find all moments
        var momentsContainer = document.getElementById('TheTimeline-moments');
        var aMoments = momentsContainer.querySelectorAll('.TheTimeline_Moment');

        // 2. parse moments
        var nMomentCount = aMoments.length;
        for (var nMomentIndex = 0; nMomentIndex < nMomentCount; nMomentIndex++)
        {
            // register
            var moment = aMoments[nMomentIndex];

            // position
            TheTimeline._positionMoment(TheTimeline._canvas, moment);
        }
    }



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Dwar timeline
     * @private
     */
    this._drawTimeline = function(canvas)
    {
        // register
        this._nWindowWidth = window.innerWidth;
        this._nWindowHeight = window.innerHeight;
        this._nMarginBottom = 150;


        // draw line
        var line = document.createElementNS("http://www.w3.org/2000/svg", "rect");
        line.setAttribute('y', this._nWindowHeight - this._nMarginBottom);
        line.setAttribute("fill", "#000000");
        line.setAttribute("width", "100%");
        line.setAttribute("height", "10px");
        canvas.appendChild(line);


        // define
        var nNumberOfDays = Math.ceil(this._nWindowWidth / this._nDayWidth);

        var aDaysNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];


        for (var nDayIndex = 0; nDayIndex < nNumberOfDays; nDayIndex++)
        {
            var dateOnTimeline = new Date(Date.now() + nDayIndex * this._nDayInMiliseconds);
            var sDateName = aDaysNames[dateOnTimeline.getDay()];

            var line = document.createElementNS("http://www.w3.org/2000/svg", "rect");
            line.setAttribute('x', 10 + nDayIndex * this._nDayWidth);
            line.setAttribute('y', this._nWindowHeight - this._nMarginBottom);
            line.setAttribute("fill", "#000000");
            line.setAttribute("width", "1");
            line.setAttribute("height", "20");
            canvas.appendChild(line);

            var text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
            text.setAttribute('x', '0');
            text.setAttribute('y', '0');
            text.setAttribute('fill', '#ffffff');
            text.setAttribute('text-anchor', 'end');
            text.setAttribute('transform', 'translate(' + (35 + nDayIndex * this._nDayWidth) + ',' + (40 + this._nWindowHeight - this._nMarginBottom) + '), rotate(-60)');
            text.textContent = (nDayIndex == 0) ? 'Today' : sDateName + ' ' + dateOnTimeline.getDate();
            canvas.appendChild(text);
        }


        // show timeline
        var timeline = document.getElementById('TheTimeline-container');
        timeline.style.display = 'block';
    }

    /**
     * Clear the existing timeline
     * @private
     */
    this._clearTimeline = function()
    {
        // remove all existing svg elements
        while (this._canvas.lastChild) {
            this._canvas.removeChild(this._canvas.lastChild)
        }
    }

    /**
     * Position moment on timeline
     */
    this._positionMoment = function(canvas, moment)
    {
        // register
        var sDate = moment.querySelector('.js-date').innerText;
        var sImportance = moment.querySelector('.js-importance').innerText;

        // calculate
        var nDaysFromToday = this._daysFromToday(sDate);

        if (nDaysFromToday < 0 || nDaysFromToday > 50)
        {
            moment.style.display = 'none';
        }
        else
        {
            // determine and draw
            var nXPosition = this._drawMoment(canvas, nDaysFromToday, sImportance);

            // position
            moment.style.left = Math.round(nXPosition - moment.offsetWidth / 2) + 'px';
            moment.style.top = '100px';

        }
    }

    /**
     * Calculate the days from today
     * @param sDate
     * @returns {number}
     * @private
     */
    this._daysFromToday = function(sDate)
    {
        // prepare
        var dateMoment = new Date(sDate.substr(0, 4), parseInt(sDate.substr(4, 2)) - 1, sDate.substr(6, 2));
        var dateToday = new Date();

        // prepare calculation parameters
        var nMomentInMilliseconds = dateMoment.getTime();
        var nTodayInMilliseconds = dateToday.getTime();
        var nDifferenceInMilliseconds = nMomentInMilliseconds - nTodayInMilliseconds;

        // calculate difference
        var nDifference = Math.round(Math.abs(nDifferenceInMilliseconds / this._nDayInMiliseconds));

        // send
        return nDifference;
    }

    this._drawMoment = function(canvas, nDaysFromToday, sType)
    {
        // prepare
        var nXPosition = 10 + nDaysFromToday * (this._nDayWidth);

        switch(sType)
        {
            case 'superimportant':

                var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                circle.setAttributeNS(null, "cx", nXPosition);
                circle.setAttributeNS(null, "cy", this._nWindowHeight - this._nMarginBottom + 5);
                circle.setAttributeNS(null, "r",  20);
                circle.setAttributeNS(null, "fill", "#000000");
                canvas.appendChild(circle);

                var innerCircle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                innerCircle.setAttributeNS(null, "cx", nXPosition);
                innerCircle.setAttributeNS(null, "cy", this._nWindowHeight - this._nMarginBottom + 5);
                innerCircle.setAttributeNS(null, "r",  10);
                innerCircle.setAttributeNS(null, "fill", "#DF5B57");
                canvas.appendChild(innerCircle);

                break;

            case 'high':

                var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                circle.setAttributeNS(null, "cx", nXPosition);
                circle.setAttributeNS(null, "cy", this._nWindowHeight - this._nMarginBottom + 5);
                circle.setAttributeNS(null, "r",  10);
                circle.setAttributeNS(null, "fill", "#000000");
                canvas.appendChild(circle);

                break;

            case 'normal':

                var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                circle.setAttributeNS(null, "cx", nXPosition);
                circle.setAttributeNS(null, "cy", this._nWindowHeight - this._nMarginBottom + 5);
                circle.setAttributeNS(null, "r",  10);
                circle.setAttributeNS(null, "fill", "#000000");
                canvas.appendChild(circle);

                break
        }

        // send
        return nXPosition;
    }

    // self init
    this.__construct();
}

// auto start
TheTimeline = new TheTimeline();
