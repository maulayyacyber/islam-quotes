var app = angular.module("app", ["ngRoute"]);

app.config(function($routeProvider) {

    $routeProvider
        .when("/", {
            templateUrl : BASE_URL+'home/homepage'
        })
        .otherwise({
            redirectTo:'/'
        });
});