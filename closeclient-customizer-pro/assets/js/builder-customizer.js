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

			// Handle adding rows
			control.container.on( 'click', '.add-row', function() {
				var newRow = {
					columns: [
						{ modules: [] },
						{ modules: [] },
						{ modules: [] },
					]
				};
				var layout = control.getLayout();
				layout.push( newRow );
				control.setting.set( JSON.stringify( layout ) );
				control.renderLayout();
			});

			// Handle removing rows
			control.container.on( 'click', '.remove-row', function() {
				var rowIndex = $(this).closest( '.h-row, .f-row' ).data( 'row' );
				var layout = control.getLayout();
				layout.splice( rowIndex, 1 );
				control.setting.set( JSON.stringify( layout ) );
				control.renderLayout();
			});

			// Handle changing column layout
			control.container.on( 'change', '.column-layout-selector', function() {
				var rowIndex = $(this).closest( '.h-row, .f-row' ).data( 'row' );
				var newLayout = $(this).val();
				var layout = control.getLayout();

				// Re-scaffold the columns for this row based on the new layout
				var newColumns = newLayout.split('-').map(function() {
					return { modules: [] };
				});
				layout[rowIndex].columns = newColumns;
				layout[rowIndex].layout = newLayout;

				control.setting.set( JSON.stringify( layout ) );
				control.renderLayout();
			});

			// Handle visibility toggles
			control.container.on( 'click', '.visibility-controls span', function() {
				var moduleEl = $(this).closest('.module');
				var device = $(this).data('device');
				var layout = control.getLayout();
				var rowIndex = moduleEl.closest('.h-row, .f-row').data('row');
				var colIndex = moduleEl.parent().data('col');
				var moduleIndex = moduleEl.index();

				var hideOn = layout[rowIndex].columns[colIndex].modules[moduleIndex].hide_on || [];
				var deviceIndex = hideOn.indexOf(device);

				if ( deviceIndex > -1 ) {
					hideOn.splice(deviceIndex, 1);
					$(this).removeClass('hidden');
				} else {
					hideOn.push(device);
					$(this).addClass('hidden');
				}

				layout[rowIndex].columns[colIndex].modules[moduleIndex].hide_on = hideOn;
				control.setting.set( JSON.stringify( layout ) );
			});

			// Handle opening the settings modal
			control.container.on( 'click', '.settings-icon', function() {
				control.openModuleSettings( $(this).closest('.module') );
			});
		},

		getColumnLayoutSelector: function( currentLayout ) {
			var layouts = {
				'1-1-1': '3 Columns',
				'1-2': '2 Columns (1/3, 2/3)',
				'2-1': '2 Columns (2/3, 1/3)',
				'1': '1 Column',
			};

			var selector = '<select class="column-layout-selector">';
			for ( var layout in layouts ) {
				selector += '<option value="' + layout + '"' + ( layout === currentLayout ? ' selected' : '' ) + '>' + layouts[layout] + '</option>';
			}
			selector += '</select>';

			return selector;
		},

		getLayout: function() {
			var control = this;
			var layout;
			try {
				layout = JSON.parse( control.setting.get() );
			} catch (e) {
				layout = [];
			}
			return layout;
		},

		renderLayout: function() {
			var control = this;
			var layout = control.getLayout();

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
				var rowEl = $( '<div class="' + rowClass + '" data-row="' + rowIndex + '"><span class="remove-row">x</span>' + control.getColumnLayoutSelector( row.layout ) + '</div>' );
				row.columns.forEach( function( col, colIndex ) {
					var colEl = $( '<div class="' + colClass + '" data-col="' + colIndex + '"></div>' );
					col.modules.forEach( function( module, moduleIndex ) {
						var moduleEl = $(
							'<div class="module" data-type="' + module.type + '">' +
							module.type +
							'<span class="remove-module">x</span>' +
							'<span class="dashicons dashicons-admin-generic settings-icon"></span>' +
							'<div class="visibility-controls">' +
							'<span class="dashicons dashicons-desktop" data-device="desktop"></span>' +
							'<span class="dashicons dashicons-tablet" data-device="tablet"></span>' +
							'<span class="dashicons dashicons-smartphone" data-device="mobile"></span>' +
							'</div>' +
							'</div>'
						);

						if ( module.hide_on ) {
							module.hide_on.forEach(function(device) {
								moduleEl.find('[data-device="' + device + '"]').addClass('hidden');
							});
						}

						colEl.append(moduleEl);
					});
					rowEl.append( colEl );
				});
				builderArea.append( rowEl );
			});

			builderArea.append( '<button class="button add-row">' + wp.i18n.__( 'Add Row' ) + '</button>' );

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
				var rowEl = $(this);
				var row = { columns: [], layout: rowEl.find('.column-layout-selector').val() };
				rowEl.find( '.h-col, .f-col' ).each( function() {
					var col = { modules: [] };
					$(this).find( '.module' ).each( function() {
						var moduleEl = $(this);
						var hideOn = [];
						moduleEl.find('.visibility-controls span.hidden').each(function() {
							hideOn.push($(this).data('device'));
						});

						var moduleData = {
							type: moduleEl.data('type'),
							hide_on: hideOn
						};

						// Get existing settings to preserve them.
						var layout = control.getLayout();
						var rowIndex = moduleEl.closest('.h-row, .f-row').data('row');
						var colIndex = moduleEl.parent().data('col');
						var moduleIndex = moduleEl.index();
						var existingModule = layout[rowIndex] && layout[rowIndex].columns[colIndex] && layout[rowIndex].columns[colIndex].modules[moduleIndex];

						if (existingModule) {
							$.extend(moduleData, existingModule);
						}

						col.modules.push(moduleData);
					});
					row.columns.push( col );
				});
				layout.push( row );
			});
			control.setting.set( JSON.stringify( layout ) );
		},

		openModuleSettings: function( moduleEl ) {
			var control = this;
			var modal = control.container.find('.module-settings-modal');
			var form = modal.find('.settings-form');
			form.empty();

			var layout = control.getLayout();
			var rowIndex = moduleEl.closest('.h-row, .f-row').data('row');
			var colIndex = moduleEl.parent().data('col');
			var moduleIndex = moduleEl.index();
			var moduleData = layout[rowIndex].columns[colIndex].modules[moduleIndex];

			// Simple form generation based on module type
			if ( moduleData.type === 'button' ) {
				form.append('<label>Text: <input type="text" name="text" value="' + (moduleData.text || '') + '"></label><br>');
				form.append('<label>Link: <input type="text" name="link" value="' + (moduleData.link || '') + '"></label>');
			} else if ( moduleData.type === 'social_icons' ) {
				// In a real app, this would be a repeater field.
				form.append('<p>Social icon settings would go here.</p>');
			}

			modal.show();

			// Save settings on form change
			form.off('change').on('change', 'input', function() {
				var name = $(this).attr('name');
				var value = $(this).val();
				moduleData[name] = value;
				control.setting.set( JSON.stringify( layout ) );
			});

			// Close modal
			modal.find('.close').off('click').on('click', function() {
				modal.hide();
			});
		}
	});

} )( jQuery, wp );
