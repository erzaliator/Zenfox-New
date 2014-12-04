Ext.ns('com.playdorm');

com.playdorm.MyTree = Ext.extend(Ext.tree.TreePanel,
{
	constructor: function(config)
	{
		com.playdorm.MyTree.superclass.constructor.call(this, Ext.applyIf(config,
		{
			collapsible: true,
			title: 'Navigation',
			width: 200,
			autoScroll: true,
			split: true,
			loader: new Ext.tree.TreeLoader(),
			root: new Ext.tree.AsyncTreeNode({
			    expanded: true,
			    children: config.children
			}),
			rootVisible: false,
			listeners: {
			    click: function(node) {
			       // Ext.Msg.alert('Navigation Tree Click', 'You clicked: "' + node.attributes.text + '"');
				//Ext.getCmp('tabPanel').update({title:'new',html:node.attributes.text});
				Ext.getCmp('tabPanel').update({title:'new', html: node.attributes.text});
			    }
			}

		}));
	}
});

Ext.reg('com.playdorm.MyTree', com.playdorm.MyTree);

