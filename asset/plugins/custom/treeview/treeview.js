(function( $ ){
    var defaults = {
        css : {
            collapsed : 'ki ki-solid-plus icon-md',
            expanded : 'ki ki-solid-minus icon-md'
        }
    }

    function __toggleCheckbox( e ) {
        var currentTarget = $(this);
        var isChecked = currentTarget.is(':checked');
        isParentChecked = (!isChecked && typeof currentTarget.data('parent') !== typeof undefined) ? false : true;
       
        /* check checkbox is disble or not */
        $("input[data-child='"+currentTarget.data('parent')+"']").each(function(index, item) {
            var item = $(item);
            ( item.is(':disabled') ) ? '' : item.prop('checked', isParentChecked);
        });

        var isAllChildChecked = false;
        if( isChecked && typeof currentTarget.data('child') !== typeof undefined ){
            //only get non diable child checkobx length
            var childCount = $("input[data-child='"+currentTarget.data('child')+"']").not(':disabled').length;
            var checkedChildCount = 0;
            $("input[data-child='"+currentTarget.data('child')+"']").each(function(index, item) {

                var item = $(item);
                checkedChildCount = ( item.is(':checked') ) ? checkedChildCount + 1 : checkedChildCount;
            });
            isAllChildChecked = (checkedChildCount == childCount) ? true: false;
        }

        $("input[data-parent='"+currentTarget.data('child')+"']").prop('checked', isAllChildChecked);

        $(this).trigger('treeview.change', currentTarget, this);
    }

    function _toggleCollapse ( e ) {
        var element = $(this);

        if(element.hasClass(defaults.css.collapsed)){
            element.parent()
                .find('>ul.collapse')
                .collapse('show')
                .parent()
                .find('>i.ki')
                .removeClass(defaults.css.collapsed)
                .addClass(defaults.css.expanded);

        }else{
            element.parent()
                .find('ul.collapse')
                .collapse('hide')
                .parent()
                .find('i.ki')
                .removeClass(defaults.css.expanded)
                .addClass(defaults.css.collapsed);
        }
    }

    var publicMethods = {
        init : function() {
            this.on('click', ".ki", _toggleCollapse);
            this.on('change', 'input.tw-control', __toggleCheckbox);
            return this;
        },
        selectedValues: function() {
            var chk = this.find('input[type="checkbox"]:checked');
            var output = [];

            chk.each(function(index, item) {
                var item = $(item);

                if(typeof item.attr('data-value') !== typeof undefined) {
                    output.push(item.attr('value'));
                }
            });

            return output;
        }
    }

    $.fn.treeview = function (options = 'init') {
        return publicMethods[ options ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    }

}( jQuery ));
