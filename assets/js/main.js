$(document).ready(function() {
    'use strict';
    // Localisation and Redirect
    $(document).languageDetection({
        languages:[
			{code:'de', path:'', defaultLanguage:true},
			{code:'en', path:'en'},
			{code:'es', path:'es'}
		]
    });
	// Fullpage Scroll
	$('#fullpage').fullpage({
		//Navigation
        menu: '#nav',
        lockAnchors: false,
        anchors:['intro', 'services', 'more', 'contact'],
        navigation: false,
        navigationPosition: 'left',
        navigationTooltips: ['Intro', 'Services', 'More', 'Contact'],
        showActiveTooltip: false,
        slidesNavigation: false,
        slidesNavPosition: 'bottom',
        //Scrolling
        css3: false,
        scrollingSpeed: 700,
        autoScrolling: true,
        fitToSection: true,
        fitToSectionDelay: 1000,
        scrollBar: false,
        easing: 'easeInOutCubic',
        easingcss3: 'ease',
        loopBottom: false,
        loopTop: false,
        loopHorizontal: true,
        continuousVertical: false,
        continuousHorizontal: false,
        scrollHorizontally: false,
        interlockedSlides: false,
        dragAndMove: false,
        offsetSections: false,
        resetSliders: false,
        fadingEffect: false,
		    scrollOverflow: false,
        scrollOverflowReset: false,
        scrollOverflowOptions: null,
        touchSensitivity: 15,
        normalScrollElementTouchThreshold: 5,
        bigSectionsDestination: null,
        //Accessibility
        keyboardScrolling: true,
        animateAnchor: true,
        recordHistory: true,
        //Design
        controlArrows: true,
        verticalCentered: true,
        sectionsColor : ['#ccc', '#fff'],
        paddingTop: '3em',
        paddingBottom: '0',
        fixedElements: '.container',
        responsiveWidth: 0,
        responsiveHeight: 0,
        responsiveSlides: false,
        //Custom selectors
        sectionSelector: '.section',
        slideSelector: '.slide',
        lazyLoading: true,
        //Mobile Scroll Override
        responsiveWidth: 600,
        //events
        onLeave: function(index, nextIndex){},
        afterLoad: function(anchorLink, index){},
        afterRender: function(){},
        afterResize: function(){},
        afterResponsive: function(isResponsive){},
        afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex){},
        onSlideLeave: function(anchorLink, index, slideIndex, direction, nextSlideIndex){}
    });
    //Gallery hover
    var windowWidth = $(window).width();
    if(windowWidth > 800){
        $("#hover1").hover(function () {
            if( $("#panel1").hasClass('active') ){
                $("#panel1").slideUp().removeClass('active');
            }
            else{
                $("#panel1").slideDown().addClass('active');
            }
        });
        $("#hover2").hover(function () {
            if( $("#panel2").hasClass('active') ){
                $("#panel2").slideUp().removeClass('active');
            }
            else{
                $("#panel2").slideDown().addClass('active');
            }
        });
    }
    //Gallery Poptrox
    var gal = $('#gallery');
    gal.poptrox({
        usePopupNav: true
    });
});
