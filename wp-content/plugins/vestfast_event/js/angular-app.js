var $jq = jQuery.noConflict();
var myApp = angular.module('ngAppEvent',['ui.router','angularjs-dropdown-multiselect','angular-loading-bar','angular.filter', 'uiGmapgoogle-maps'])
    .run(
    ['$rootScope', '$state', '$stateParams','$location',
        function ($rootScope,   $state,   $stateParams, $location) {

            // It's very handy to add references to $state and $stateParams to the $rootScope
            // so that you can access them from any scope within your applications.For example,
            // <li ng-class="{ active: $state.includes('contacts.list') }"> will set the <li>
            // to active whenever 'contacts.list' or one of its decendents is active.
            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;
        }
    ]
)
    .config(['$stateProvider', '$urlRouterProvider',
        function ($stateProvider,   $urlRouterProvider) {

            /////////////////////////////
            // Redirects and Otherwise //
            /////////////////////////////

            // Use $urlRouterProvider to configure any redirects (when) and invalid urls (otherwise).
            $urlRouterProvider

                // The `when` method says if the url is ever the 1st param, then redirect to the 2nd param
                // Here we are just setting up some convenience urls.
                //   .when('/c?id', '/contacts/:id')
                //   .when('/user/:id', '/contacts/:id')

                // If the url is ever invalid, e.g. '/asdf', then redirect to '/' aka the home state
                .otherwise('/');

            //////////////////////////
            // State Configurations //
            //////////////////////////

            // Use $stateProvider to configure your states.
            $stateProvider

                .state("home", {
                    url: "/",
                    templateUrl: pluginUrl + 'ang_templates/events.html',
                    controller: 'VetEventsController'
                })

                .state("event", {
                    url: "/event/:eventId",
                    templateUrl: pluginUrl + 'ang_templates/showevent.html',
                    controller: 'VetShowEventController'
                })
        }
    ]
);


myApp.config(function ($provide) {
    $provide.decorator('$uiViewScroll', function ($delegate) {
        return function (uiViewElement) {
            // var top = uiViewElement.getBoundingClientRect().top;
            //window.scrollTo(200, 0);
            //var scrollToElement = document.getElementById("searchstart");
            //console.log(scrollToElement);
            //window.scrollTo(0, 0);

            // Or some other custom behaviour...
         //  scrollToElement.scrollIntoView();
        };
    });
});

myApp.filter('search', function($filter){
    return function(items, text){

        if (!text || text.length === 0)
            return items;

        // split search text on space
        var searchTerms = text.split(' ');

        // search for single terms.
        // this reduces the item list step by step
        searchTerms.forEach(function(term) {
            if (term && term.length)
                items = $filter('filter')(items, term);
        });
        return items
    };
});

myApp.filter('dateToTime', function(){
    return function(item){
        if(item === undefined) return "";
        var datum = item;
        var re = new RegExp("-", 'g');
        var da = datum.replace(re, "/");
        var d = new Date(da);
        var hours = ("0" + d.getHours().toString()).slice(-2);
        var minutes = ("0" + d.getMinutes().toString()).slice(-2);
        return hours + ":" + minutes;
    }
});

myApp.filter('dateToDateText', function(){
    return function(item){
        if(item === undefined) return "";

        var weekDays = ["Söndag","Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag"];
        var monthName = ["Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "September", "Oktober", "November", "December"];

        var days = new Array();
        var daysObjects = new Array();

        var dObj =  new Object();
        var d = new Date(item.split(" ")[0]);
        dObj.weekDayName = weekDays[d.getDay()];
        dObj.monthName = monthName[d.getMonth()];
        dObj.dateText = d.getDate();

        return dObj.weekDayName + " " +  dObj.dateText + " " + dObj.monthName;
    }

});


myApp.service('searchStatesService', function() {
    var data = {};
    var selectedDaysData = [];
    var selectedCategorysData = [];
    var familyFilterData = 0;
    var searchStringData = "";
    var venuesData;

    this.setSelectedCategoreis= function(arr){
        selectedCategorysData = arr;
    };
    this.getSelectedCategoreis= function(){
        return selectedCategorysData;
    };

    this.setSelectedDays= function(arr){
        selectedDaysData = arr;
    };
    this.getSelectedDays= function(){
        return selectedDaysData;
    };

    this.setFamilyFilter= function(ss){
        familyFilterData = ss;
    };
    this.getFamilyFilter= function(){
        return familyFilterData;
    };

    this.setSearchStringFilter= function(searchString){
        searchStringData = searchString;
    };
    this.getSearchStringFilter= function(){
        return searchStringData;
    };

    this.setvenueFilter= function(venues){
        venuesData = venues;
    };

    this.getvenueFilter= function(){
        return venuesData;
    };
});


myApp.factory('eventService', [
    '$http', '$q',
    function eventService($http, $q) {


        // interface
        var service = {
            eventsList: [],
            getEvents: getEvents,
            getEventbyId: getEventbyId,
            getSubjects: getSubjects
        };
        return service;

        function getEvents() {
            var def = $q.defer();
            var req = {
                method: 'post',
                cache: true,
                headers:{
                    'Accept': 'application/json, text/javascript',
                    'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                url: ajaxurl,
                transformRequest: function(obj) {
                    var str = [];
                    for(var p in obj)
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    return str.join("&");
                },
                data: { action: 'getEvents' }
            }
            $http(req).success(function (data) {
                service.eventsList = data;
                def.resolve(data);

            })
                .error(function () {
                    def.reject("Failed to get albums");
                });


            return def.promise;
        }

        function getEventbyId(searchEventId) {
            //console.log('getEventbyId service fired' + searchEventId);
            var def = $q.defer();
            var req = {
                method: 'post',
                headers:{
                    'Accept': 'application/json, text/javascript',
                    'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                url: ajaxurl,
                transformRequest: function(obj) {
                    var str = [];
                    for(var p in obj)
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    return str.join("&");
                },
                data: { action: 'getEvent', eventId: searchEventId }
            }
            $http(req).success(function (data) {
                //service.vEvents = data;
                def.resolve(data);
                //console.log('getEventbyId service Success ' + searchEventId);
            })
                .error(function () {
                    //console.log('getEventbyId service FAILED ' + searchEventId);
                    def.reject("Failed to get albums");
                });


            return def.promise;
        }

        function getSubjects() {
            //console.log('album service fired' + ajaxurl);
            var def = $q.defer();
            var req = {
                method: 'post',
                headers:{
                    'Accept': 'application/json, text/javascript',
                    'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                url: ajaxurl,
                transformRequest: function(obj) {
                    var str = [];
                    for(var p in obj)
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    return str.join("&");
                },
                data: { action: 'get_event' }
            }
            $http(req).success(function (data) {
                //service.vEvents = data;
                def.resolve(data);
                //console.log('albums (simple) returned to controller.', data);
            })
                .error(function () {
                    def.reject("Failed to get albums");
                });


            return def.promise;
        }



    }
]);

myApp.controller('VetShowEventController', function ($scope,$stateParams, $state , eventService, uiGmapGoogleMapApi) {

    $scope.eventData;
    $scope.options = {scrollwheel: false};
    $scope.coordsUpdates = 0;
    $scope.dynamicMoveCtr = 0;
    $scope.dynamicUrl = "";

    $scope.$watchCollection("marker.coords", function (newVal, oldVal) {
        if (_.isEqual(newVal, oldVal))
            return;
        $scope.coordsUpdates++;
    });



    uiGmapGoogleMapApi.then(function(maps) {

    });


    function createDataMarker(eventItem){
        var latLong = eventItem.geo_position.split(",");
        var latitude = latLong[0];
        latitude = latitude.trim();
        var longitude = latLong[1];
        longitude = longitude.trim();

        eventItem.gmap = {};
        var _map = { center: { latitude: latitude, longitude: longitude}, zoom: 13 };
        var _marker = {
            id: eventItem.eventId,
            coords: {
                latitude: latitude,
                longitude: longitude
            },
            options: { draggable: false }

        };
        eventItem.gmap.map = _map;
        eventItem.gmap.marker = _marker;
    }
        //document.location.toString().toLowerCase()
    $scope.getEventUrl = function () {
        $scope.dynamicUrl = "http://www.facebook.com/plugins/share_button.php?href=" + encodeURIComponent(document.location.href) + "&layout=button_count";
        //$scope.dynamicUrl = encodeURIComponent(document.location.href);
    }

    $scope.getEvent = function (id) {
        //Nice hack to remove header content :-)
        $jq('.eventContent').hide();
        eventService.getEventbyId(id)
            .then(function (myEvent) {
                $scope.getEventUrl();

                $scope.eventData = myEvent[0];
                if($scope.eventData.geo_position != "" ){
                    createDataMarker($scope.eventData);
                };
                //console.log("DATA SUCCESS ");
                //console.log(myEvent);
            },
            function () {
                //console.log('Load error.');
            });

    };
    $scope.getEvent($stateParams.eventId);
})

myApp.controller('VetEventsController', function ($scope ,$stateParams, eventService,searchStatesService ) {
    $scope.venueListDropdownTexts = {buttonDefaultText: 'VÄLJ PLATS', checkAll: 'MARKERA ALLA', uncheckAll:'AVMARKERA ALLA',  dynamicButtonTextSuffix:'VALDA PLATSER' };
    $scope.selectedDaysList = [];
    $scope.selectedSubjectsList = [];
    $scope.eventList = [];
    // $scope.filteredEventList =  $filter('searchDays')($scope.eventList);
    $scope.subjectsList = [];
    $scope.subjectsListObjects = new Array();
    $scope.daysListObjects = new Array();
    $scope.venueListObjects = new Array();
    $scope.familyFilter = 0;
    $scope.venueListDropdownModel = [];
    $scope.indexedGroups = [];
    $scope.searchText2 = "";

    $scope.venueListDropdownSettings = {
        scrollableHeight: '300px',
        scrollable: true,
        buttonClasses: 'btnvenueListDropdown btn-venueListDropdown',
        displayProp: 'label',
        idProp: 'id',
        externalIdProp: ''
    };
    $jq('.eventContent').show();



    function init(){
       $scope.selectedDaysList = searchStatesService.getSelectedDays();
        for (var i = 0; i < $scope.daysListObjects.length; i++) {
            if(($scope.selectedDaysList.indexOf($scope.daysListObjects[i].cleanDayDate) >= 0) && ($scope.selectedDaysList.length > 0)){
                $scope.daysListObjects[i].selected = true;
            }
        }
       $scope.selectedSubjectsList = searchStatesService.getSelectedCategoreis();
        for (var i = 0; i < $scope.subjectsListObjects.length; i++) {
            //console.log($scope.subjectsListObjects);
            if(($scope.selectedSubjectsList.indexOf($scope.subjectsListObjects[i].subject) >= 0) && ($scope.selectedSubjectsList.length > 0)){
                $scope.subjectsListObjects[i].selected = true;
            }
        }
        $scope.familyFilter = searchStatesService.getFamilyFilter();
        $scope.searchText2 = searchStatesService.getSearchStringFilter();
        if(searchStatesService.getvenueFilter() != undefined)
            $scope.venueListDropdownModel = searchStatesService.getvenueFilter();
    };

    $scope.search = function (item){
        if (item.subjectList.indexOf($scope.query) != -1) {
            return true;
        }
        return false;
    };

    $scope.searchDays = function (item){
        if($scope.selectedDaysList.length == 0){
            return true;
        }
        var res = item.event_start.split(" ");
        if (($scope.selectedDaysList.indexOf(res[0]) != -1) ) {
            return true;
        }
        return false;
    }

    $scope.searchSubjects = function (item){
        //console.log($scope.selectedSubjectsList);
        if($scope.selectedSubjectsList.length == 0){
            return true;
        }
        if (checkInSubjects(item, $scope.selectedSubjectsList)) {
            //console.log("!!!!!!!!!!!!!!!!!!!!!!!");
            return true;
        }
        return false;
    }



    $scope.searchVenues = function (item){
        var venues = Array();
        //console.log($scope.venueListDropdownModel);
        for (var i = 0; i < $scope.venueListDropdownModel.length; i++) {
            venues.push($scope.venueListDropdownModel[i].label);
        }
        if($scope.venueListDropdownModel.length == 0){
            return true;
        }
        if (venues.indexOf(item.venue) != -1) {
            return true;
        }
        return false;
    }

    function checkInSubjects(item, selectedSubjects ){
        //console.log("--"+  item.title + item.subjectList.length );
        //console.log( item.subjectList );
        var foundInArray = false;
        if(item.subjectList.length > 0) {

            for (var i = 0; i < item.subjectList.length; i++) {
                if (selectedSubjects.indexOf(item.subjectList[i]) != -1) {
                    foundInArray = true;
                }
            }
            return foundInArray;
        }else{
            return false;
        }
    }

    $scope.familyFilterClick = function (){
        if( $scope.familyFilter == 1 ){
            $scope.familyFilter = 0;
            searchStatesService.setFamilyFilter(0);
        }else{
            $scope.familyFilter = 1
            searchStatesService.setFamilyFilter(1);
        }
    }

    $scope.textSearchChange = function (){
        searchStatesService.setSearchStringFilter($scope.searchText2);
    }

    $scope.venueSelect = function(){
        searchStatesService.setvenueFilter($scope.venueListDropdownModel);
    }

    $scope.filterSubjectClick = function (){
        //console.log(this.subject.subject);
        var selectedSubject = this.subject.subject;
        this.subject.selected = !this.subject.selected;

        if($scope.selectedSubjectsList.indexOf(selectedSubject) == -1 ){
            $scope.selectedSubjectsList.push(selectedSubject);
        }
        else{
            var pos =  $scope.selectedSubjectsList.indexOf(selectedSubject);
            $scope.selectedSubjectsList.splice(pos, 1);
        }
        searchStatesService.setSelectedCategoreis($scope.selectedSubjectsList)
        //console.log($scope.selectedSubjectsList);
    }

    $scope.filterDaysClick =  function (){
        if($scope.selectedDaysList.indexOf(this.day.cleanDayDate) == -1 ){
            $scope.selectedDaysList.push(this.day.cleanDayDate);
            this.day.selected = true;
        }
        else{
            var pos =  $scope.selectedDaysList.indexOf(this.day.cleanDayDate);
            $scope.selectedDaysList.splice(pos, 1);
            this.day.selected = false;
        }
        searchStatesService.setSelectedDays($scope.selectedDaysList);
    }

    $scope.searchFamilyFilter = function (item){
        if(searchStatesService.getFamilyFilter() == 0){
            return true;
        }
        else{
            if(item.family_activity == 1){
                return true
            }
        }
        return false;
    }

   /* $scope.filterDaysGroup = function(eventItem) {
        var groupIsNew = $scope.indexedGroups.indexOf(eventItem.event_dategroup) == -1;
        if (groupIsNew) {
            $scope.indexedGroups.push(eventItem.event_dategroup);
            //console.log($scope.indexedGroups);
        }
        return groupIsNew;
    }*/

    $scope.getEvents = function () {
        //console.log("loading Events");
        eventService.getEvents()
            .then(function (myEvents) {
                $scope.eventList = myEvents;
             //   console.log("Events Loaded");
                renderDateGroupName();
                renderDateButtons()
                renderSubjects();
                renderVenues();
                 init();
              //  console.log(eventService.eventsList);
            },
            function () {
                //console.log('albums retrieval failed.');
            });

    };

    function renderDateGroupName(){
        var weekDays = ["Söndag","Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag"];
        var monthName = ["Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "September", "Oktober", "November", "December"];
        var days = new Array();
        for (var i = 0; i < $scope.eventList.length; i++) {
            var tempDate = $scope.eventList[i]["event_start"].split(" ")[0];
            var dObj =  new Object();
            var d = new Date($scope.eventList[i]["event_start"].split(" ")[0]);
            dObj.cleanDayDate = $scope.eventList[i]["event_start"].split(" ")[0];
            dObj.weekDayName = weekDays[d.getDay()];
            dObj.monthName = monthName[d.getMonth()];
            dObj.dateText = d.getDate();
            //Add text
            $scope.eventList[i]["event_dategroup"] = dObj.weekDayName + " " +  dObj.dateText + " " + dObj.monthName;
           // console.log( dObj);
            var groupIsNew = $scope.indexedGroups.indexOf($scope.eventList[i]["event_dategroup"]) == -1;
            if (groupIsNew) {
                //console.log("Adding: " + $scope.eventList[i]);
                $scope.indexedGroups.push($scope.eventList[i]);
                //console.log($scope.indexedGroups);
            }
        }
    }

    function renderDateButtons(){
        var weekDays = ["Söndag","Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag"];
        var monthName = ["Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "September", "Oktober", "November", "December"];

        var days = new Array();
        var daysObjects = new Array();

        for (var i = 0; i < $scope.eventList.length; i++) {
            //var tempDate = d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate();
            var tempDate = $scope.eventList[i]["event_start"].split(" ")[0];
            if(days.indexOf(tempDate) == -1){
                var dObj =  new Object();
                //days. push(d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate());
                //console.log($scope.eventList[i]["event_start"].split(" ")[0]);
                var d = new Date($scope.eventList[i]["event_start"].split(" ")[0]);
                dObj.cleanDayDate = $scope.eventList[i]["event_start"].split(" ")[0];
                dObj.weekDayName = weekDays[d.getDay()];
                dObj.monthName = monthName[d.getMonth()];
                dObj.dateText = d.getDate();
                dObj.selected = false;
                dObj.event_dategroup = dObj.weekDayName + " " +  dObj.dateText + " " + dObj.monthName;
                daysObjects.push(dObj);

                days.push($scope.eventList[i]["event_start"].split(" ")[0]);
            }
        }


        $scope.daysListObjects = daysObjects;
    }

    function renderSubjects(){

        var subjectsList = new Array();
        var subjectsListObjects = new Array();

        for (var i = 0; i < $scope.eventList.length; i++) {
            var subList = $scope.eventList[i]['subjectList'];
            if(subList.length > 0){
                for (var ii = 0; ii < subList.length; ii++) {
                    if(subjectsList.indexOf(subList[ii]) == -1){
                        var subjectObj =  new Object();
                        subjectObj.subject = subList[ii];
                        subjectObj.selected = false;

                        subjectsList.push(subList[ii]);
                        subjectsListObjects.push(subjectObj);
                    }
                }
            }
        }
        //console.log(subjectsListObjects);
        $scope.subjectsList = subjectsList;
        $scope.subjectsListObjects = subjectsListObjects;
    }

    function renderVenues(){

        var venueList = new Array();
        var venueListObjects = new Array();

        for (var i = 0; i < $scope.eventList.length; i++) {
            var venue = String($scope.eventList[i]['venue']).trim();

            if(venue !=''){
                if(venueList.indexOf(venue) == -1){
                    var venueObj =  new Object();
                    venueObj.venue = venue;
                    venueObj.label = venue;
                    venueObj.id = $scope.eventList[i]['eventId'];
                    venueObj.selected = false;
                    venueList.push(venue);
                    venueListObjects.push(venueObj);
                }
            }
        }
        $scope.venueListObjects = venueListObjects;
    }

    $scope.getEvents();
})


