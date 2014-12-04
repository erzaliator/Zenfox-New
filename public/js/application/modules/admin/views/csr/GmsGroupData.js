Ext.namespace("Ext.ux");
Ext.ux.RemoteCheckboxGroup = Ext.extend(Ext.form.CheckboxGroup,
{
  baseParams: null,
  url: '',
  defaultItems:
  [
    {
      boxLabel: 'no options',
      disabled: true
    }
  ],
  fieldId: 'id',
  fieldName: 'name',
  fieldLabel: 'boxLabel',
  fieldValue: 'inputValue',
  fieldChecked: 'checked',
  reader: null,
  
  onRender: function(H, F)
  {

    this.items = this.defaultItems;
   
    if ((this.url != '') && (this.reader != null))
    {
fail = function(){};
     


cbObj = this;
handleCB = function (responseObj){
     
      var response = Ext.decode(responseObj.responseText);

     
      if (response.success)
      {
        var data = cbObj.reader.readRecords(Ext.decode(responseObj.responseText));

        var item;
        var record;
        var id, name, checked;
       
        for (var i = 0; i < data.records.length; i++)
        {
          record = data.records[i];
          item =
          {
            boxLabel: record.get(cbObj.fieldLabel),
            inputValue: record.get(cbObj.fieldValue)
          }
         
          if (cbObj.fieldId != '')
          {
            item.id = record.get(cbObj.fieldId);
          }
         
          if (cbObj.fieldName != '')
          {
            item.name = record.get(cbObj.fieldName);
          }
         
          if (cbObj.fieldChecked != '')
          {
            item.checked = record.get(cbObj.fieldChecked);
          }

         cbObj.items[i] = item;

        }
Ext.ux.RemoteCheckboxGroup.superclass.onRender.call(cbObj, H, F)
      }
   
}
   
}
Ext.Ajax.request({
          headers:['Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8'],
          method:'POST',
          url:this.url,
          params:this.baseParams,
          autoAbort:false,
success:handleCB,
failure:fail
});


  },
  
  reload:function(){
    this.items = this.defaultItems;
   
    if ((this.url != '') && (this.reader != null))
    {

     
    this.removeAll(); //ensure we clear existing checkboxes

    cbObj = this; //save a reference to the checkboxgroup
    handleCB = function (responseObj){
          
      
      var response = Ext.decode(responseObj.responseText);

     
      if (response.success)
      {
        var data = cbObj.reader.readRecords(Ext.decode(responseObj.responseText));

        var item;
        var record;
        var id, name, checked;
       
        for (var i = 0; i < data.records.length; i++)
        {
          record = data.records[i];
          item =
          {
            boxLabel: record.get(cbObj.fieldLabel),
            inputValue: record.get(cbObj.fieldValue)
          }
         
          if (cbObj.fieldId != '')
          {
            item.id = record.get(cbObj.fieldId);
          }
         
          if (cbObj.fieldName != '')
          {
            item.name = record.get(cbObj.fieldName);
          }
         
          if (cbObj.fieldChecked != '')
          {
            item.checked = record.get(cbObj.fieldChecked);
          }

        var chk = cbObj.panel.getComponent(0).add(item);
        cbObj.items[i] = chk;
        cbObj.panel.getComponent(0).doLayout();
        }
        
    Ext.ux.RemoteCheckboxGroup.superclass.onRender.call(cbObj, H, F)
      }
   
    }
   
    }
    var fail = function(){};
    Ext.Ajax.request({
          headers:['Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8'],
          method:'POST',
          url:this.url,
          params:this.baseParams,
          autoAbort:false,
    success:handleCB,
    failure:fail
    });
  },
  removeAll:function(){
      cbObj = this;
      for (var j=0;j<this.columns;j++){
          if (cbObj.panel.getComponent(j).items.length > 0){
              cbObj.panel.getComponent(j).items.each(
                  function(i){
                      i.destroy();
              });
          }
      }
  }
});
Ext.reg("remotecheckboxgroup", Ext.ux.RemoteCheckboxGroup);