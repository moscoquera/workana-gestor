<!-- array input -->
<?php
$max = isset($field['max']) && (int)$field['max'] > 0 ? $field['max'] : -1;
$min = isset($field['min']) && (int)$field['min'] > 0 ? $field['min'] : -1;
$item_name = strtolower(isset($field['entity_singular']) && !empty($field['entity_singular']) ? $field['entity_singular'] : $field['label']);

$items = old($field['name']) ? (old($field['name'])) : (isset($field['value']) ? ($field['value']) : (isset($field['default']) ? ($field['default']) : ''));

// make sure not matter the attribute casting
// the $items variable contains a properly defined JSON

if (is_array($items)) {
    if (count($items)) {
        $items = json_encode($items);
    } else {
        $items = '[]';
    }
} elseif (is_string($items) && !is_array(json_decode($items))) {
    $items = '[]';
}



?>
<div
        ng-app="backPackChildApp"
        ng-controller="tableController"
        @include('crud::inc.field_wrapper_attributes')
>

    <h3>{!! $field['label'] !!}</h3>
    @include('crud::inc.field_translatable_icon')

    <input class="array-json" type="hidden" id="{{ $field['name'] }}" name="{{ $field['name'] }}">

    <div class="array-container form-group">

        <table
                class="table table-bordered table-striped m-b-0"
                ng-init="field = '#{{ $field['name'] }}'; items = {{ $items }}; max = {{$max}}; min = {{$min}}; maxErrorTitle = '{{trans('backpack::crud.table_cant_add', ['entity' => $item_name])}}'; maxErrorMessage = '{{trans('backpack::crud.table_max_reached', ['max' => $max])}}'"
        >

            <thead>
            <tr>
                @foreach( $field['columns'] as $column )
                    <th style="font-weight: 600!important;">
                        {{ $column['label'] }}
                    </th>
                @endforeach
                <th class="text-center" ng-if="max == -1 || max > 1"> {{-- <i class="fa fa-trash"></i> --}} </th>
            </tr>
            </thead>

            <tbody ui-sortable="sortableOptions" ng-model="items" class="table-striped">

            <tr post-render ng-repeat="item in items" class="array-row">


                @foreach ($field['columns'] as $column)
                    <td
                            class="
                                @if(isset($column['size']))
                                    col-md-{{ $column['size'] }}
                            @endif
                                    "
                    >
                        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        @if(view()->exists('vendor.backpack.crud.fields.'.$column['type']))
                            @include('vendor.backpack.crud.fields.'.$column['type'], array('field' => $column,'super'=>$field))
                        @else
                            @include('crud::fields.'.$column['type'], array('field' => $column,'super'=>$field))
                        @endif
                    </td>
                @endforeach

                <td ng-if="max == -1 || max > 1">
                    <button ng-hide="min > -1 && $index < min" class="btn btn-sm btn-default" type="button"
                            ng-click="removeItem(item);"><span class="sr-only">delete item</span><i class="fa fa-trash"
                                                                                                    role="presentation"
                                                                                                    aria-hidden="true"></i>
                    </button>
                </td>
            </tr>

            </tbody>

        </table>

        <div class="array-controls btn-group m-t-10">
            <button ng-if="max == -1 || items.length < max" class="btn btn-sm btn-default" type="button"
                    ng-click="addItem()"><i class="fa fa-plus"></i> Adicionar item ({{ $item_name }})
            </button>
        </div>

    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        {{-- @push('crud_fields_styles')
            {{-- YOUR CSS HERE --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-select/0.20.0/select.css" />

    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        {{-- YOUR JS HERE --}}

        @if (!$crud->child_resource_included['angular'])
            <?php $crud->child_resource_included['angular'] =true;?>
        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>

        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.5.8/angular-sanitize.js"></script>

        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-sortable/0.14.3/sortable.min.js"></script>

        <script type="application/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-select/0.19.8/select.js" ></script>
        @endif
        <script>


            window.angularChildApp = window.angularChildApp || angular.module('backPackChildApp', ['ui.select', 'ngSanitize','ui.sortable'], function ($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });


            window.angularChildApp.controller('tableController', function ($scope) {

                @foreach($fields as $key=>$_field)
                        @if($_field['type']=='child')
                            @foreach ($_field['columns'] as $column)
                                    @if ( $column['type'] == 'child_select' )
                                        $scope.{{$column['name']}}_fields={!! $column['model']::all() !!}
                                    @elseif ( $column['type'] == 'child_select2' )
                                        $scope.{{$column['name']}}_fields={!! $column['model']::all() !!}
                                    @endif
                            @endforeach
                        @endif
                @endforeach

                $scope.sortableOptions = {
                    handle: '.sort-handle'
                };

                $scope.addItem = function () {

                    if ($scope.max > -1) {
                        if ($scope.items.length < $scope.max) {
                            var item = { {{ isset($field['child_pivot'])?$field['child_pivot'].':{}':'' }} };
                            $scope.items.push(item);
                        } else {
                            new PNotify({
                                title: $scope.maxErrorTitle,
                                text: $scope.maxErrorMessage,
                                type: 'error'
                            });
                        }
                    }
                    else {
                        var item = { {{ isset($field['child_pivot'])?$field['child_pivot'].':{}':'' }} };
                        $scope.items.push(item);
                    }


                }

                $scope.educationUpdate=function(item,model){
                    console.log(item);
                    console.log(model);
                    alert("*");
                }

                $scope.removeItem = function (item) {
                    var index = $scope.items.indexOf(item);
                    $scope.items.splice(index, 1);
                }

                $scope.$watch('items', function (a, b) {

                    if ($scope.min > -1) {
                        while ($scope.items.length < $scope.min) {
                            $scope.addItem();
                        }
                    }

                    if (typeof $scope.items != 'undefined' && $scope.items.length) {

                        if (typeof $scope.field != 'undefined') {
                            if (typeof $scope.field == 'string') {
                                $scope.field = $($scope.field);
                            }
                            $scope.field.val(angular.toJson($scope.items));
                        }
                    }

                }, true);

                if ($scope.min > -1) {
                    for (var i = 0; i < $scope.min; i++) {
                        $scope.addItem();
                    }
                }
            });
            window.angularChildApp.directive('postRender', function ($timeout) {
                return {
                    restrict:'A',
                    link: function (scope, element, attrs) {
                        $timeout(function () {
                            $('.select2').each(function (i, obj) {
                                if (!$(obj).data("select2")) {
                                    //      $(obj).select2();
                                }
                            });





                        });
                    }
                }
            });

            window.angularChildApp.directive('convertNumber', function() {
                return {
                    require: 'ngModel',
                    link: function(scope, el, attr, ctrl) {
                        ctrl.$parsers.push(function(value) {
                            return parseInt(value, 10);
                        });

                        ctrl.$formatters.push(function(value) {
                            if (value != undefined){
                                return value.toString();
                            }

                            return "";
                        });
                    }
                }
            });

            window.angularChildApp.directive('datetimez', function() {
                return {
                    restrict: 'A',
                    replace: true,
                    transclude: true,
                    scope: {
                        label: '@',
                        ngModel: '='
                    },
                    link: function(scope, element, attrs, ngModelCtrl) {
                        $('[data-bs-datepicker]',$(element).parent()).each(function (i, obj) {

                            if (!$(obj).data("datepicker")) {

                                var $fake = $(this),
                                    $field = $fake.closest('input[type="hidden"]'),
                                    $customConfig = $.extend({
                                        format: 'dd/mm/yyyy'
                                    }, $fake.data('bs-datepicker'));
                                $picker = $fake.bootstrapDP($customConfig);

                                var $existingVal = $field.val();
                                if (scope.ngModel){
                                    $existingVal=scope.ngModel;
                                }

                                if ($existingVal!=undefined && $existingVal.length) {
                                    // Passing an ISO-8601 date string (YYYY-MM-DD) to the Date constructor results in
                                    // varying behavior across browsers. Splitting and passing in parts of the date
                                    // manually gives us more defined behavior.
                                    // See https://stackoverflow.com/questions/2587345/why-does-date-parse-give-incorrect-results
                                    var parts = $existingVal.split('-')
                                    var year = parts[0]
                                    var month = parts[1] - 1 // Date constructor expects a zero-indexed month
                                    var day = parts[2]
                                    preparedDate = new Date(year, month, day).format($customConfig.format);
                                    $fake.val(preparedDate);
                                    $picker.bootstrapDP('update', preparedDate);
                                }

                                $fake.on('keydown', function (e) {
                                    e.preventDefault();
                                    return false;
                                });

                                $picker.on('show hide change onChange', function (e) {
                                    if (e.date) {
                                        var sqlDate = e.format('yyyy-mm-dd');
                                    } else {
                                        try {
                                            var sqlDate = $fake.val();

                                            if ($customConfig.format === 'dd/mm/yyyy') {
                                                sqlDate = new Date(sqlDate.split('/')[2], sqlDate.split('/')[1] - 1, sqlDate.split('/')[0]).format('yyyy-mm-dd');
                                            }
                                        } catch (e) {
                                            if ($fake.val()) {
                                                PNotify.removeAll();
                                                new PNotify({
                                                    title: 'Whoops!',
                                                    text: 'Sorry we did not recognise that date format, please make sure it uses a yyyy mm dd combination',
                                                    type: 'error',
                                                    icon: false
                                                });
                                            }
                                        }
                                    }
                                    $field.val(sqlDate);
                                    var $e = angular.element($field);
                                    $e.triggerHandler('input');
                                    scope.$apply(function(scope){
                                        $field.val(sqlDate);
                                        $field.trigger('input'); // Use for Chrome/Firefox/Edge
                                        $field.trigger('change'); // Use for Chrome/Firefox/Edge + IE11
                                        element.trigger('change'); // Use for Chrome/Firefox/Edge + IE11
                                        scope.ngModel=sqlDate;
                                        /*console.log(sqlDate);
                                        console.log($field.val());
                                        console.log(scope.items);
                                        console.log(attrs);
                                        console.log(scope.ngModel);
                                        console.log("*******************************");*/
                                    });


                                });
                            }
                        });
                    }
                };
            });

            window.angularChildApp.filter('propsFilter', function() {
                return function(items, props) {
                    var out = [];
                    if (angular.isArray(items)) {
                        items.forEach(function(item) {
                            var itemMatches = false;

                            var keys = Object.keys(props);
                            for (var i = 0; i < keys.length; i++) {
                                var prop = keys[i];
                                var text = props[prop].toLowerCase();
                                if (item[prop] != undefined && item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                                    itemMatches = true;
                                    break;
                                }
                            }

                            if (itemMatches) {
                                out.push(item);
                            }
                        });
                    } else {
                        // Let the output be the input untouched
                        out = items;
                    }

                    return out;
                };
            });

            angular.element(document).ready(function () {
                angular.forEach(angular.element('[ng-app]'), function (ctrl) {
                    var ctrlDom = angular.element(ctrl);
                    if (!ctrlDom.hasClass('ng-scope')) {
                        angular.bootstrap(ctrl, [ctrlDom.attr('ng-app')]);
                    }
                });
            });

        </script>
    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}