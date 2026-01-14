( function( $, wp ) {
	'use strict';

	wp.customize.controlConstructor['closeclient_builder'] = wp.customize.Control.extend({
		ready: function() {
			var control = this;

			// Make modules draggable
			control.container.find( '.available-modules .module' ).draggable({
				helper: 'clone',
				revert: 'invalid',
				connectToSortable: '.builder-area .h-col, .builder-area .f-col',
			});

			// Make columns sortable
			control.container.find( '.builder-area' ).sortable({
				axis: 'y',
				update: function() {
					control.updateValue();
				}
			});

			control.container.find( '.h-col, .f-col' ).sortable({
				connectWith: '.h-col, .f-col',
				placeholder: 'module-placeholder',
				update: function() {
					control.updateValue();
				}
			});

			// Initial render
			control.renderLayout();

			// Handle removing modules
			control.container.on( 'click', '.remove-module', function() {
				$(this).parent().remove();
				control.updateValue();
			});
		},

		renderLayout: function() {
			var control = this;
			var layout;
			try {
				layout = JSON.parse( control.setting.get() );
			} catch (e) {
				layout = [];
			}

			var builderArea = control.container.find( '.builder-area' );
			builderArea.empty();

			// Default to one row with 3 columns if layout is empty.
			if ( !layout || layout.length === 0 ) {
				layout = [
					{
						columns: [
							{ modules: [] },
							{ modules: [] },
							{ modules: [] },
						]
					}
				];
			}

			var rowClass = control.params.builder_type === 'footer' ? 'f-row' : 'h-row';
			var colClass = control.params.builder_type === 'footer' ? 'f-col' : 'h-col';

			layout.forEach( function( row, rowIndex ) {
				var rowEl = $( '<div class="' + rowClass + '" data-row="' + rowIndex + '"></div>' );
				row.columns.forEach( function( col, colIndex ) {
					var colEl = $( '<div class="' + colClass + '" data-col="' + colIndex + '"></div>' );
					col.modules.forEach( function( module ) {
						colEl.append(
							'<div class="module" data-type="' + module.type + '">' +
							module.type +
							'<span class="remove-module">x</span>' +
							'</div>'
						);
					});
					rowEl.append( colEl );
				});
				builderArea.append( rowEl );
			});

			// Re-init sortable on the new elements
			control.container.find( '.h-col, .f-col' ).sortable({
				connectWith: '.h-col, .f-col',
				placeholder: 'module-placeholder',
				update: function() {
					control.updateValue();
				}
			});
		},

		updateValue: function() {
			var control = this;
			var layout = [];
			control.container.find( '.builder-area .h-row, .builder-area .f-row' ).each( function() {
				var row = { columns: [] };
				$(this).find( '.h-col, .f-col' ).each( function() {
					var col = { modules: [] };
					$(this).find( '.module' ).each( function() {
						col.modules.push({
							type: $(this).data( 'type' ),
						});
					});
					row.columns.push( col );
				});
				layout.push( row );
			});
			control.setting.set( JSON.stringify( layout ) );
		}
	});

} )( jQuery, wp );
