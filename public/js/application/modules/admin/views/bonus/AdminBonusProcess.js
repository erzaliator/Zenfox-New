Ext.ns('com.playdorm');

com.playdorm.AdminBonusProcess = Ext.extend(Ext.grid.GridPanel, 
{
	constructor: function(config)
	{
		config = config || {};

		var editor = new Ext.ux.grid.RowEditor({
		    saveText: 'Update'
		});

	    editor.on({
	    	scope: this,
	    	afteredit: function(roweditor, changes, record, rowIndex) {
	    	//your save logic here - might look something like this:
	    	Ext.Ajax.request({
	    		url   : '/bonus/process/format/json',
	    		method: 'POST',
	    		params: changes,
	    		success: function() {
	    			alert('done');
	    		//post-processing here - this might include reloading the grid if there are calculated fields
	    		}
	    	   });
	    	}
	        });

		var bonus = Ext.data.Record.create([{
	        name: 'levelName',
	        type: 'string'
	    }, {
	        name: 'minPoints',
	        type: 'string'
	    }, {
	        name: 'maxPoints',
	        type: 'string',
	    },{
	        name: 'bonusPercent',
	        type: 'string'
	    },{
	        name: 'fixedBonus',
	        type: 'string'
	    },{
	        name: 'minDeposit',
	        type: 'string'
	    },{
	        name: 'minTotalDeposit',
	        type: 'string'
	    },{
	        name: 'rewardTimes',
	        type: 'string'
	    },{
	        name: 'fixedReal',
	        type: 'string'
	    }
	    ]);
		
	    var store = new Ext.data.GroupingStore({});
	    
		com.playdorm.AdminBonusProcess.superclass.constructor.call(this, Ext.applyIf(config,
		{
			frame: true,
			loadMask: true,
			title : 'Bonus Schemes',
			closable : true,
	        store: store,
	        //region:'center',
	        //margins: '0 5 5 5',
	        //autoExpandColumn: 'name',
	        plugins: [editor],
	        view: new Ext.grid.GroupingView({
	            markDirty: false
	        }),
	        tbar: [{
	            text: 'Add Bonus Scheme',
	            handler: function(){
	                var e = new bonus({
	                	levelName : ''
	                });
	                editor.stopEditing();
	                store.insert(0, e);
	                this.getView().refresh();
	                this.getSelectionModel().selectRow(0);
	                editor.startEditing(0);
	            }
	        }],

	        columns: [
		        new Ext.grid.RowNumberer(),
		        {
		            id: 'levelName',
		            header: 'Level Name',
		            dataIndex: 'levelName',
		            sortable: true,
		            editor: {
		                xtype: 'textfield',
		                allowBlank: false
		            }
		        },
		        {
		            id: 'minPoints',
		            header: 'Minimum Points',
		            dataIndex: 'minPoints',
		            sortable: true,
		            editor: {
		                xtype: 'textfield',
		                allowBlank: false
		            }
		        },{
		        	id : 'maxPoints',
		            header: 'Maximum Points',
		            dataIndex: 'maxPoints',
		            sortable: true,
		            editor: {
		                xtype: 'textfield',
		                allowBlank: false,
		            }
		        },{
		        	id : 'bonusPercent',
		            header: 'Bonus Percent',
		            dataIndex: 'bonusPercent',
		            sortable: true,
		            editor: {
		                xtype: 'textfield',
		                allowBlank: false,
		            }
		        },{
		        	id : 'fixedBonus',
		            header: 'Fixed Bonus',
		            dataIndex: 'fixedBonus',
		            sortable: true,
		            editor: {
		                xtype: 'textfield',
		                allowBlank: false,
		            }
		        },{
		        	id : 'minDeposit',
		            header: 'Minimum Deposit',
		            dataIndex: 'minDeposit',
		            sortable: true,
		            editor: {
		                xtype: 'textfield',
		                allowBlank: false,
		            }
		        },{
		        	id : 'minTotalDeposit',
		            header: 'Minimum Total Deposit',
		            dataIndex: 'minTotalDeposit',
		            sortable: true,
		            editor: {
		                xtype: 'textfield',
		                allowBlank: false,
		            }
		        },{
		        	id : 'rewardTimes',
		            header: 'Reward Times',
		            dataIndex: 'rewardTimes',
		            sortable: true,
		            editor: {
		                xtype: 'textfield',
		                allowBlank: false,
		            }
		        },{
		        	id : 'fixedReal',
		            header: 'Fixed Real',
		            dataIndex: 'fixedReal',
		            sortable: true,
		            editor: {
		                xtype: 'textfield',
		                allowBlank: false,
		            }
		        },		    
		    ]
		}));
	},

});

Ext.reg('com.playdorm.AdminBonusProcess', com.playdorm.AdminBonusProcess);		