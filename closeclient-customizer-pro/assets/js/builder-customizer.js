( function( $, wp ) {
	'use strict';

	wp.customize.controlConstructor['closeclient_builder'] = wp.customize.Control.extend({
		ready: function() {
			var control = this;
            var styleClipboard = null;

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
            control.renderGlobalComponents();

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

			// Handle opening the style panel
			control.container.on( 'click', '.style-icon', function() {
				var moduleEl = $(this).closest('.module');
				var layout = control.getLayout();
				var rowIndex = moduleEl.closest('.h-row, .f-row').data('row');
				var colIndex = moduleEl.parent().data('col');
				var moduleIndex = moduleEl.index();
				var moduleData = layout[rowIndex].columns[colIndex].modules[moduleIndex];

				var sectionId = 'closeclient_module_' + moduleData.id;

				// See if the section already exists
				var section = wp.customize.section( sectionId );

				if ( ! section ) {
					// Create the section if it doesn't exist
					section = new wp.customize.Section( sectionId, {
						title: 'Style: ' + moduleData.type,
						panel: control.params.panel,
						priority: 100
					});
					wp.customize.section.add( section );
				}

				// Now you can add controls to this section.
				control.addStyleControls( sectionId, moduleData );

				section.focus();
			});

            // Handle copying styles
            control.container.on( 'click', '.copy-style-icon', function() {
                var moduleEl = $(this).closest('.module');
                var layout = control.getLayout();
                var rowIndex = moduleEl.closest('.h-row, .f-row').data('row');
                var colIndex = moduleEl.parent().data('col');
                var moduleIndex = moduleEl.index();
                var moduleData = layout[rowIndex].columns[colIndex].modules[moduleIndex];

                if ( moduleData.style ) {
                    styleClipboard = JSON.parse(JSON.stringify(moduleData.style)); // Deep copy
                    alert('Styles copied!');
                } else {
                    alert('No styles to copy.');
                }
            });

            // Handle pasting styles
            control.container.on( 'click', '.paste-style-icon', function() {
                if ( ! styleClipboard ) {
                    alert('No styles in clipboard.');
                    return;
                }

                var moduleEl = $(this).closest('.module');
                var layout = control.getLayout();
                var rowIndex = moduleEl.closest('.h-row, .f-row').data('row');
                var colIndex = moduleEl.parent().data('col');
                var moduleIndex = moduleEl.index();
                var moduleData = layout[rowIndex].columns[colIndex].modules[moduleIndex];

                moduleData.style = JSON.parse(JSON.stringify(styleClipboard)); // Deep copy
                control.setting.set( JSON.stringify( layout ) );

                // Trigger preview update
                var styleString = '';
                for (var key in moduleData.style) {
                    if (moduleData.style.hasOwnProperty(key)) {
                        var cssKey = key.replace(/_/g, '-');
                        styleString += cssKey + ': ' + moduleData.style[key] + '; ';
                    }
                }
                var style = '<style>#module-' + moduleData.id + ' { ' + styleString + ' }</style>';
                wp.customize.previewer.send( 'update-module-style', { moduleId: 'module-' + moduleData.id, style: style } );

                alert('Styles pasted!');

                // Optional: refresh the style panel if it's open for this module
                var sectionId = 'closeclient_module_' + moduleData.id;
                var section = wp.customize.section( sectionId );
                if ( section && section.expanded() ) {
                    control.addStyleControls( sectionId, moduleData );
                }
            });

            // Handle saving a module as a global component
            control.container.on( 'click', '.save-global-icon', function() {
                var moduleEl = $(this).closest('.module');
                var layout = control.getLayout();
                var rowIndex = moduleEl.closest('.h-row, .f-row').data('row');
                var colIndex = moduleEl.parent().data('col');
                var moduleIndex = moduleEl.index();
                var moduleData = JSON.parse(JSON.stringify(layout[rowIndex].columns[colIndex].modules[moduleIndex])); // Deep copy

                var name = prompt('Enter a name for your global component:');
                if ( name ) {
                    var globalId = 'global-' + Math.random().toString(36).substr(2, 9);

                    var components = control.getGlobalComponents();
                    delete moduleData.id; // Remove instance ID before saving
                    components[globalId] = {
                        name: name,
                        module: moduleData
                    };

                    wp.customize.value('closeclient_global_components').set( JSON.stringify(components) );
                    control.renderGlobalComponents();
                    alert('Component saved!');
                }
            });

            // Handle opening the conditionals modal
            control.container.on( 'click', '.conditionals-icon', function() {
                control.openConditionalsModal( $(this).closest('.module') );
            });
		},

        openConditionalsModal: function( moduleEl ) {
            var control = this;
            var modal = control.container.find('.module-conditionals-modal');
            var form = modal.find('.conditionals-form');
            form.empty();

            var layout = control.getLayout();
            var rowIndex = moduleEl.closest('.h-row, .f-row').data('row');
            var colIndex = moduleEl.parent().data('col');
            var moduleIndex = moduleEl.index();
            var moduleData = layout[rowIndex].columns[colIndex].modules[moduleIndex];

            var conditions = moduleData.conditions || [];

            // UI for adding new conditions
            var addConditionHtml = `
                <div class="add-condition">
                    <select class="condition-type">
                        <option value="">-- Select Condition --</option>
                        <option value="is_singular">Is Singular Page</option>
                        <option value="is_user_logged_in">User is Logged In</option>
                    </select>
                    <button class="button add-condition-btn">Add</button>
                </div>
            `;
            form.append(addConditionHtml);

            // Display existing conditions
            var existingConditionsHtml = '<div class="existing-conditions">';
            conditions.forEach(function(condition, index) {
                existingConditionsHtml += `
                    <div class="condition" data-index="${index}">
                        <span>${condition.type.replace(/_/g, ' ')}</span>
                        <button class="remove-condition-btn">Remove</button>
                    </div>
                `;
            });
            existingConditionsHtml += '</div>';
            form.append(existingConditionsHtml);

            modal.show();

            // Handle adding a condition
            form.find('.add-condition-btn').on('click', function() {
                var newType = form.find('.condition-type').val();
                if ( newType ) {
                    if (!moduleData.conditions) {
                        moduleData.conditions = [];
                    }
                    moduleData.conditions.push({ type: newType });
                    control.setting.set( JSON.stringify( layout ) );
                    control.openConditionalsModal( moduleEl ); // Re-render the modal
                }
            });

            // Handle removing a condition
            form.find('.remove-condition-btn').on('click', function() {
                var index = $(this).closest('.condition').data('index');
                moduleData.conditions.splice(index, 1);
                control.setting.set( JSON.stringify( layout ) );
                control.openConditionalsModal( moduleEl ); // Re-render the modal
            });

            // Close modal
			modal.find('.close').off('click').on('click', function() {
				modal.hide();
			});
        },

        getGlobalComponents: function() {
			var components;
			try {
				components = JSON.parse( wp.customize.value('closeclient_global_components')() );
			} catch (e) {
				components = {};
			}
			return components;
		},

		renderGlobalComponents: function() {
			var control = this;
			var components = control.getGlobalComponents();
			var listEl = control.container.find('.global-components-list');
			listEl.empty();

			for ( var id in components ) {
				if ( components.hasOwnProperty( id ) ) {
					var component = components[id];
					var componentEl = $(
						'<div class="module global-component" data-global-id="' + id + '">' +
						component.name +
						'</div>'
					);
					listEl.append(componentEl);
				}
			}

			// Make global components draggable
			listEl.find('.global-component').draggable({
				helper: 'clone',
				revert: 'invalid',
				connectToSortable: '.builder-area .h-col, .builder-area .f-col',
			});
		},

		addStyleControls: function( sectionId, moduleData ) {
			var control = this;
			var moduleType = moduleData.type;
			var moduleId = moduleData.id;

			// A more comprehensive set of style controls
			var styleControls = {
				button: [
					{ id: 'background_color', label: 'Background Color', type: 'color' },
					{ id: 'text_color', label: 'Text Color', type: 'color' },
					{ id: 'padding', label: 'Padding (e.g., 10px 20px)', type: 'text' },
					{ id: 'border_radius', label: 'Border Radius (e.g., 5px)', type: 'text' },
					{ id: 'font_size', label: 'Font Size (e.g., 16px)', type: 'text' },
					{ id: 'font_weight', label: 'Font Weight', type: 'select', choices: { '400': 'Normal', '700': 'Bold' } }
				],
				logo: [
					{ id: 'text_color', label: 'Text Color', type: 'color' },
					{ id: 'font_size', label: 'Font Size (e.g., 24px)', type: 'text' },
					{ id: 'font_weight', label: 'Font Weight', type: 'select', choices: { '400': 'Normal', '700': 'Bold' } },
					{ id: 'padding', label: 'Padding', type: 'text' }
				],
				navigation: [
					{ id: 'link_color', label: 'Link Color', type: 'color' },
					{ id: 'link_hover_color', label: 'Link Hover Color', type: 'color' },
					{ id: 'font_size', label: 'Font Size', type: 'text' },
					{ id: 'padding', label: 'Padding', type: 'text' },
				],
				social_icons: [
					{ id: 'icon_color', label: 'Icon Color', type: 'color' },
					{ id: 'icon_hover_color', label: 'Icon Hover Color', type: 'color' },
					{ id: 'icon_size', label: 'Icon Size (e.g., 20px)', type: 'text' },
				],
				announcement_bar: [
					{ id: 'background_color', label: 'Background Color', type: 'color' },
					{ id: 'text_color', label: 'Text Color', type: 'color' },
					{ id: 'font_size', label: 'Font Size', type: 'text' },
				]
			};

			if ( styleControls[moduleType] ) {
				// Clear any existing controls in the section first
				var section = wp.customize.section( sectionId );
				section.controls().forEach(function(control) {
					wp.customize.control.remove(control.id);
				});


				styleControls[moduleType].forEach(function( styleControl ) {
					var settingId = 'module_style_' + moduleId + '_' + styleControl.id;

					// Use existing setting if possible, otherwise create it
					var setting = wp.customize.instance(settingId);
					if ( ! setting ) {
						var initialValue = (moduleData.style && moduleData.style[styleControl.id]) ? moduleData.style[styleControl.id] : '';
						setting = wp.customize.create( settingId, initialValue );
					}

					var controlOptions = {
						label: styleControl.label,
						section: sectionId,
						settings: { 'default': settingId },
					};

					// Choose control type
					if ( styleControl.type === 'color' ) {
						wp.customize.control.add( new wp.customize.ColorControl( settingId, controlOptions ) );
					} else if ( styleControl.type === 'select' ) {
						controlOptions.type = 'select';
						controlOptions.choices = styleControl.choices;
						wp.customize.control.add( new wp.customize.Control( settingId, controlOptions ) );
					} else { // 'text'
						controlOptions.type = 'text';
						wp.customize.control.add( new wp.customize.Control( settingId, controlOptions ) );
					}

					// Bind the preview update
					wp.customize( settingId ).bind( function( to ) {
						if ( ! moduleData.style ) {
							moduleData.style = {};
						}
						moduleData.style[styleControl.id] = to;
						control.setting.set( JSON.stringify( control.getLayout() ) );

						// Generate and send the full style block
						var styleString = '';
						for (var key in moduleData.style) {
							if (moduleData.style.hasOwnProperty(key)) {
								// Simple snake_case to kebab-case conversion
								var cssKey = key.replace(/_/g, '-');
								styleString += cssKey + ': ' + moduleData.style[key] + '; ';
							}
						}

						var style = '<style>#module-' + moduleId + ' { ' + styleString + ' }</style>';
						wp.customize.previewer.send( 'update-module-style', { moduleId: 'module-' + moduleId, style: style } );
					});
				});
			}
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
                            '<span class="dashicons dashicons-star-filled save-global-icon" title="Save as Global"></span>' +
                            '<span class="dashicons dashicons-admin-page copy-style-icon" title="Copy Styles"></span>' +
                            '<span class="dashicons dashicons-clipboard paste-style-icon" title="Paste Styles"></span>' +
                            '<span class="dashicons dashicons-art conditionals-icon" title="Conditionals"></span>' +
							'<span class="dashicons dashicons-admin-generic settings-icon"></span>' +
							'<span class="dashicons dashicons-admin-customizer style-icon"></span>' +
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

						var moduleData = {};
                        var globalId = moduleEl.data('global-id');

                        if ( globalId ) {
                            moduleData = {
                                global_id: globalId,
                                type: control.getGlobalComponents()[globalId].module.type
                            };
                        } else {
						    moduleData = {
							    type: moduleEl.data('type'),
							    hide_on: hideOn
						    };
                        }

						// Get existing settings to preserve them.
						var rowIndex = moduleEl.closest('.h-row, .f-row').data('row');
						var colIndex = moduleEl.parent().data('col');
						var moduleIndex = moduleEl.index();
						var existingModule = control.getLayout()[rowIndex] && control.getLayout()[rowIndex].columns[colIndex] && control.getLayout()[rowIndex].columns[colIndex].modules[moduleIndex];

						if (existingModule && existingModule.id) {
							moduleData.id = existingModule.id;
							$.extend(moduleData, existingModule);
						} else {
							moduleData.id = 'module-' + Math.random().toString(36).substr(2, 9);
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
				var networks = ['facebook', 'twitter', 'instagram', 'linkedin'];
				networks.forEach(function(network) {
					var var_val = (moduleData[network] || '');
					form.append('<label>' + network.charAt(0).toUpperCase() + network.slice(1) + ': <input type="text" name="' + network + '" value="' + var_val + '"></label><br>');
				});
			} else if ( moduleData.type === 'announcement_bar' ) {
				form.append('<label>Text: <input type="text" name="text" value="' + (moduleData.text || '') + '"></label><br>');
				form.append('<label>Link: <input type="text" name="link" value="' + (moduleData.link || '') + '"></label>');
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
