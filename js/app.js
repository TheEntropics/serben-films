var module = angular.module('app', []);
module.directive('backImg', function() {
    return function(scope, element, attrs) {
        var url = attrs.backImg;
        element.css({
            'background-image' : 'url(' + url + ')',
            'background-size' : 'cover',
			'background-position' : '50% 50%'
        });
    };
});
module.controller('controller', function($scope) {
    $scope.films = [];
    $scope.search = "";

    $scope.searchFilter = function(item) {
        var title = (item.title.toLowerCase().indexOf($scope.search.toLowerCase()) !== -1);
        var filename = (item.filename.toLowerCase().indexOf($scope.search.toLowerCase()) !== -1);
        var language = (item.language.toLowerCase().indexOf($scope.search.toLowerCase()) !== -1);
        return title || filename || language;
    };

    $scope.splitFilms = function() {
        var filmsPerRow = 5;
        var filmRows = [];
        for (var i = 0; i < arr.length; i += filmsPerRow) {
            filmRows.push($scope.films.slice(i, i+filmsPerRow));
        }
        return filmRows;
    }

    setTimeout(function () {
        $.getJSON( "getfilms.php", function(data) {
            $scope.films = data;
            $scope.$apply();
            console.log($scope.films);
        }).fail(function() {
            console.log( "An error occured while loading the list of films." );
        });
    }, 1000);
});
