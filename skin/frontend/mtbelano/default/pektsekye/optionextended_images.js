

var OptionExtended = {};

OptionExtended.Images = Class.create({


  v : [], 
  o : [], 
  imageLayerIds : [], 
  templatePattern : /(^|.|\r|\n)({{(\w+)}})/, 



  initialize : function(){
    Object.extend(this, OptionExtended.Config);
        
    this.mainImage = $(this.mainImageId);   
    if (!this.mainImage){
      var imgBox = $$('.product-img-box')[0];
      if (imgBox){
        var img = imgBox.down('img');
        if (img)
          this.mainImage = img;
      }      
    }   
    if (!this.mainImage)
      this.mainImage =  {src:null};
    
    this.mainImageSrc = this.mainImage.src;
    this.descriptionTemplate = new Template(this.description, this.templatePattern);    
    this.imagePopupTemplate = new Template(this.imagePopup, this.templatePattern);
    
    var optionsContainer = $('product-options-wrapper');
    if (optionsContainer && optionsContainer.getWidth() < 590 ){
      this.layoutGroup = 'narrow';  
    } else {
      this.layoutGroup = 'wide';        
    }
  },  



  load : function(element, optionId){
    if (!this.o[optionId]){
      this.o[optionId] = {};
      this.isNewOption = true;        
      this.dd = element.up('dd');
      this.prepareOption(optionId, element);
    }
    if (element.type == 'radio' || element.type == 'checkbox') {  
      if (element.value){
        var valueId = parseInt(element.value);  
        this.v[valueId] = {};     
      }
      this.prepareValue(optionId, element, element.value);  
    } else if ((element.type == 'select-one' && !Element.hasClassName(element,'datetime-picker')) || element.type == 'select-multiple') { 
      var options = $A(element.options);
      for (var i = 0, len = options.length; i < len; ++i){
        if (options[i].value){
          var valueId = parseInt(options[i].value);
          this.v[valueId] = {};     
        }
        this.prepareValue(optionId, element, options[i].value);       
      } 
    }
  },

  
  
  
  prepareOption : function(optionId, element){
    
    switch (this.config[0][optionId][1]){
      case 'above' : 
        if (element.type == 'radio' || element.type == 'select-one') {
          this.dd.className ='optionextended-' + this.layoutGroup + '-above';                 
          Element.insert(this.dd, {'top': new Element('div', {'id' : 'optionextended_description_' + optionId, 'style' : 'display:none;'}).addClassName('description')});         
          Element.insert(this.dd, {'top': this.makeImage(optionId, null, 'one')});        
          Element.insert(this.dd, {'top': new Element('div').addClassName('spacer').update('&nbsp;')});           
          Element.insert(this.dd.down('.description'), {'after': new Element('div').addClassName('spacer').update('&nbsp;')});  
        } else {
          this.dd.className ='optionextended-' + this.layoutGroup + '-above-checkbox';          
        }
      break;
      case 'before' :   
        if (element.type == 'select-one'){          
          this.dd.className ='optionextended-' + this.layoutGroup + '-before-select'; 
          Element.insert(element, {'before': this.makeImage(optionId, null, null)});      
          Element.insert(element, {'after': this.descriptionTemplate.evaluate({style : 'style="display:none;"', description : '', 'optionId' : optionId})});          
          Element.insert(this.dd, {'bottom': new Element('div').addClassName('spacer').update('&nbsp;')});          
        } else if(element.type == 'radio'){       
          this.dd.className ='optionextended-' + this.layoutGroup + '-before-radio';    
          Element.insert(this.dd, {'top': this.makeImage(optionId, null, null)});
          Element.insert(this.dd, {'top': new Element('div').addClassName('spacer').update('&nbsp;')});           
          Element.insert(this.dd, {'bottom': new Element('div').addClassName('spacer').update('&nbsp;')});          
        } 
      break;
      case 'below' :  
        if (element.type == 'radio' || element.type == 'select-one') {  
          this.dd.className ='optionextended-' + this.layoutGroup + '-below';             
          Element.insert(this.dd, {'bottom':  this.makeImage(optionId, null, 'one')});          
          Element.insert(this.dd, {'bottom': new Element('div', {'id' : 'optionextended_description_' + optionId, 'style' : 'display:none;'}).addClassName('description')});          
          Element.insert(this.dd.down('img'), {'before': new Element('div').addClassName('spacer').update('&nbsp;')});            
          Element.insert(this.dd, {'bottom': new Element('div').addClassName('spacer').update('&nbsp;')});  
        } else {
          this.dd.className ='optionextended-' + this.layoutGroup + '-below-checkbox';        
        }
      break;
      case 'swap' :     
        if (element.type == 'select-one'){          
          this.dd.className ='optionextended-' + this.layoutGroup + '-swap-select';     
          Element.insert(element, {'after': new Element('div', {'id' : 'optionextended_description_' + optionId, 'style' : 'display:none;'}).addClassName('description')});               
        } else if(element.type == 'radio'){       
          this.dd.className ='optionextended-' + this.layoutGroup + '-swap-radio';    
          Element.insert(this.dd, {'top': new Element('div').addClassName('spacer').update('&nbsp;')});           
          Element.insert(this.dd, {'bottom': new Element('div').addClassName('spacer').update('&nbsp;')});          
        } 
      break;
      case 'pickerswap' :       
      case 'picker' :         
        this.dd.className ='optionextended-' + this.layoutGroup + '-picker';      
        Element.insert(element, {'after': new Element('div', {'id' : 'optionextended_description_' + optionId, 'style' : 'display:none;'}).addClassName('description')});               
      break;
      case 'grid' : 
        this.dd.className = 'optionextended-' + this.layoutGroup + '-grid';
        var ul = this.dd.down('ul');
        Element.insert(ul, {'top': new Element('div').addClassName('spacer').update('&nbsp;')});
        Element.insert(ul, {'bottom': new Element('div').addClassName('spacer').update('&nbsp;')});
      break;
      case 'list' :         
        this.dd.className ='optionextended-' + this.layoutGroup + '-list';        
      break;  
    } 
    
    Element.insert(this.dd, {'bottom': new Element('div').addClassName('optionextended-' + this.layoutGroup + '-note').update(this.config[0][optionId][0])});
  },
  
  
  
  
  prepareValue : function(optionId, element, value){
    
    var valueId = value ? parseInt(value) : null;
    
    if (value)
      var imageUrl = this.thumbnailDirUrl + this.config[1][valueId][0];
    
    switch (this.config[0][optionId][1]){
      
      case 'above' : 
      
        if (value){
          if (this.config[1][valueId][0]){
            if (element.type == 'radio' || element.type == 'select-one'){     
              this.v[valueId].thumbnail = new Image();
              this.v[valueId].thumbnail.src = imageUrl;
            } else {
              if (this.isNewOption){
                Element.insert(this.dd, {'top': this.makeImage(optionId, valueId, null)});                
                this.isNewOption = false;               
              } else {  
                Element.insert(previousImage, {'after': this.makeImage(optionId, valueId, null)});                            
              }
              previousImage = $('optionextended_v_image_' + valueId);
              if (element.type == 'select-multiple')
                this.v[valueId].selected = false;                       
            }
          }
          if (this.config[1][valueId][1] && element.type == 'checkbox'){
            Element.insert(element.up('li').down('.label'), {'bottom': this.descriptionTemplate.evaluate({style : '', description : this.config[1][valueId][1], 'optionId' : optionId})});            
          }           
        } 
        
      break;
      case 'before' :   
      
        if (value){
          if (this.config[1][valueId][0]){      
            this.v[valueId].thumbnail = new Image();
            this.v[valueId].thumbnail.src = imageUrl;
          }
          if (this.config[1][valueId][1] && element.type == 'radio'){
            Element.insert(element.up('li').down('.label'), {'bottom': this.descriptionTemplate.evaluate({style : '', description : this.config[1][valueId][1], 'optionId' : optionId})});            
          } 
        } 
        
      break;
      case 'below' :  
      
        if (value){
          if (this.config[1][valueId][0]){
            if (element.type == 'radio' || element.type == 'select-one'){     
              this.v[valueId].thumbnail = new Image();
              this.v[valueId].thumbnail.src = imageUrl;
            } else {
              if (this.isNewOption){
                Element.insert(this.dd.down('.optionextended-' + this.layoutGroup + '-note'), {'before': this.makeImage(optionId, valueId, null)});             
                this.isNewOption = false;               
              } else {  
                Element.insert(previousImage, {'after': this.makeImage(optionId, valueId, null)});                            
              }
              previousImage = $('optionextended_v_image_' + valueId);
              if (element.type == 'select-multiple')
                this.v[valueId].selected = false;                     
            }
          }
          if (this.config[1][valueId][1] && element.type == 'checkbox'){
            Element.insert(element.up('li').down('.label'), {'bottom': this.descriptionTemplate.evaluate({style : '', description : this.config[1][valueId][1], 'optionId' : optionId})});            
          }         
        } 
        
      break;
      case 'swap' : 
      
        if (value){
          if (this.config[1][valueId][0]){      
            this.v[valueId].thumbnail = new Image();
            this.v[valueId].thumbnail.src = imageUrl;
          }
          if (this.config[1][valueId][1] && element.type == 'radio'){
            Element.insert(element.up('li').down('.label'), {'bottom': this.descriptionTemplate.evaluate({style : '', description : this.config[1][valueId][1], 'optionId' : optionId})});            
          } 
        } 
        
      break;
      case 'pickerswap' :
      
        if (value && this.config[1][valueId][0]){ 
            this.v[valueId].thumbnail = new Image();
            this.v[valueId].thumbnail.src = imageUrl;
        }         
          
      case 'picker' : 
      
        if (value && this.config[1][valueId][0]) {
          if (this.isNewOption){
            Element.insert(this.dd, {'top': this.makeImage(optionId, valueId, null)});              
            this.isNewOption = false;               
          } else {  
            Element.insert(previousImage, {'after': this.makeImage(optionId, valueId, null)});                            
          }
          previousImage = $('optionextended_v_image_' + valueId);
        }   
        
      break;
      case 'grid' :       
      
        Element.insert(element, {'before':  this.makeImage(optionId, valueId, null)});
        if (value && this.config[1][valueId][1])
          Element.insert(element, {'after': this.descriptionTemplate.evaluate({style : '', description : this.config[1][valueId][1], 'optionId' : optionId})});   
          
      break;
      case 'list' :   
      
/* 
---------------The folowing javascript code changes html structure from:-------------------
<li>
  <input class="radio  product-custom-option" onclick="opConfig.reloadPrice()" name="options[88]" id="options_88_3" value="192" type="radio">
  <span class="label">
    <label for="options_88_3">
      TITLE HERE ...
      <span class="price-notice">+<span class="price">PRICE HERE ...</span></span>
    </label>
  </span>
</li>
-------------------------to:
<li>
  <label for="options_88_3">
      <img onclick="optionExtended.popup(88, 192)" class="optionextended-image" src="http://...jpg">
  </label>
  <span class="content">
    <label for="options_88_3">
      TITLE HERE ...
      <div class="description">DESCRIPTION HERE ...</div>
      <span class="price-notice">+<span class="price">PRICE HERE ...</span></span>
    </label>
    <input class="radio  product-custom-option" onclick="opConfig.reloadPrice()" name="options[88]" id="options_88_3" value="192" type="radio">
  </span>
  <div class="spacer">&nbsp;</div>
</li>
------------------------------
*/      
        var li = element.up('li');

        Element.insert(li, {'top': this.makeImage(optionId, valueId, null)});   
          
        var content  = li.down('span.label');
        
        content.className = 'content';
        
        Element.insert(content, {'bottom': element}); 
        
        if (value){             
          var description = new Element('div').addClassName('description').update(this.config[1][valueId][1]);
          var price = content.down('span.price-notice');
          if (price)
            Element.insert(price, {'before': description}); 
          else
            Element.insert(content.down('label'), {'bottom': description});           
        } else {
          li.addClassName('none');          
        } 
          
        Element.insert(li, {'bottom': new Element('div').addClassName('spacer').update("&nbsp;")}); 
      break;  
    } 
  },
  


  observeRadio : function(optionId, valueId){
    if (this.config[0][optionId][1] == 'above' || this.config[0][optionId][1] == 'below'){  
      this.reloadDescription(optionId, valueId);
    } 
    this.reloadImage(optionId, valueId, 'radio', null); 
    this.o[optionId].value = valueId;   
  },
  
  observeCheckbox : function(element, optionId, valueId){   
    this.reloadImage(optionId, valueId, 'checkbox', element.checked); 
  },
  
  observeSelectOne : function(element, optionId){
    var valueId = element.value; 
    if (this.config[0][optionId][1] == 'pickerswap'){
      this.reloadPickerImage(optionId, valueId);    
      this.reloadImage(optionId, valueId, 'select-one', null);            
    } else if (this.config[0][optionId][1] == 'picker'){
      this.reloadPickerImage(optionId, valueId);
    } else {
      this.reloadImage(optionId, valueId, 'select-one', null);      
    }
    
    if (this.config[0][optionId][1] == 'before')
      this.reloadDescriptionIcon(optionId, valueId);        
    else
      this.reloadDescription(optionId, valueId);        
    
    this.o[optionId].value = valueId;       
  },
  
  observeSelectMultiple : function(element, optionId){
      var options = $A(element.options);    
      var l = options.length;
      while (l--){      
        if (this.config[1][options[l].value][0] && this.v[options[l].value].selected !== options[l].selected){                  
          this.reloadImage(optionId, options[l].value, 'select-multiple', options[l].selected);           
          this.v[options[l].value].selected = options[l].selected;  
        } 
      } 
  },  
  
  
  
  
  reloadImage : function(optionId, valueId, type, checked){
    if (type == 'radio' || type == 'select-one') {
      if (valueId && this.config[1][valueId][0]){   
        this.showImage(optionId, valueId, type);
      } else {
        if (valueId && (this.config[0][optionId][1] == 'above' || this.config[0][optionId][1] == 'below') && this.config[1][valueId][1]){
          this.setPlaceholder(optionId);
        } else if(valueId && this.config[0][optionId][1] == 'before'){
          this.setPlaceholder(optionId);        
        } else {
          this.hideImage(optionId, valueId, type);
        }
      }
    } else {
      if (checked && valueId && this.config[1][valueId][0])   
        this.showImage(optionId, valueId, type);
      else
        this.hideImage(optionId, valueId, type);      
    }
  },
  
  showImage : function(optionId, valueId, type){
    if (this.config[0][optionId][1] != 'grid' && this.config[0][optionId][1] != 'list'){
      if (type == 'radio' || type == 'select-one') {
        if (this.config[0][optionId][1] == 'swap' || this.config[0][optionId][1] == 'pickerswap'){  
          this.mainImage.src = this.v[valueId].image.src;         
          this.resetZoom();     
          if (this.imageLayerIds.indexOf(optionId) == -1)
            this.imageLayerIds.push(optionId);
        } else {          
          var image = $('optionextended_image_' + optionId);
          if (this.config[0][optionId][2] && image.style.cursor != 'pointer'){      
            image.style.cursor = 'pointer';
            image.title = this.imageTitle;
            var popupJs = this.imagePopupTemplate.evaluate({'url' : '\'' + this.imageDirUrl + '\'+optionExtended.config[1][optionExtended.o[' + optionId + '].value][0]'});           
            image.onclick = function(){eval(popupJs)};
          }         
          image.src = this.v[valueId].thumbnail.src;
          image.show();
        }     
      } else {
        $('optionextended_v_image_' + valueId).show();
      }
    }
  },  
  
  hideImage : function(optionId, valueId, type){
    if (this.config[0][optionId][1] != 'grid' && this.config[0][optionId][1] != 'list'){
      if (type == 'radio' || type == 'select-one') {
        if (this.config[0][optionId][1] == 'swap' || this.config[0][optionId][1] == 'pickerswap'){  
          this.imageLayerIds = this.imageLayerIds.without(optionId);
          var src = this.imageLayerIds.last() ? this.v[this.o[this.imageLayerIds.last()].value].image.src : this.mainImageSrc;        
          if (this.mainImage.src != src){ 
            this.mainImage.src = src;       
            this.resetZoom();           
          }
        } else if (this.config[0][optionId][1] == 'before'){
          var image = $('optionextended_image_' + optionId);
          if (image){
            if (this.config[0][optionId][2] && image.style.cursor == 'pointer'){      
              image.style.cursor = null;
              image.title = '';
              image.onclick = null;
            }         
            image.src = this.spacer;  
          }
        } else {
          var image = $('optionextended_image_' + optionId);
          if (image){
            image.src = this.spacer;
            image.hide();
          }
        }             
      } else if(this.config[1][valueId][0]){
        $('optionextended_v_image_' + valueId).hide();      
      }
    }
  },
  
  setPlaceholder : function(optionId){
      var image = $('optionextended_image_' + optionId);    
      if (this.config[0][optionId][2] && image.style.cursor == 'pointer'){      
        image.style.cursor = null;
        image.title = '';
        image.onclick = null;
      } 
      image.src = this.placeholderUrl;    
      image.show();
  },
  
  
  
  
  reloadDescription : function(optionId, valueId){  
    if (valueId && this.config[1][valueId][1])
      this.showDescription(optionId, valueId);
    else
      this.hideDescription(optionId);
  },
  
  showDescription : function(optionId, valueId){  
    var description = $('optionextended_description_' + optionId);
    description.update(this.config[1][valueId][1]);
    description.show();     
  },
  
  hideDescription : function(optionId){ 
    var description = $('optionextended_description_' + optionId);
    if (description)    
      description.hide();   
  },
  
  
  
  
  reloadDescriptionIcon : function(optionId, valueId){  
    if (valueId && this.config[1][valueId][1])
      this.showDescriptionIcon(optionId, valueId);
    else
      this.hideDescriptionIcon(optionId);
  },
  
  showDescriptionIcon : function(optionId, valueId){  
    $('optionextended_description_dd_' + optionId).update(this.config[1][valueId][1]);
    $('optionextended_description_' + optionId).show();   
  },
  
  hideDescriptionIcon : function(optionId){
    var container = $('optionextended_description_' + optionId);
    if (container)
      container.hide();   
  },




  reloadPickerImage : function(optionId, valueId){
    if (valueId && this.config[1][valueId][0])
      this.highlightPickerImage(valueId);
    if (this.o[optionId].value && this.o[optionId].value != valueId && this.config[1][this.o[optionId].value][0])
      this.unhighlightPickerImage(this.o[optionId].value);    
  },
  
  highlightPickerImage : function(valueId){
    $('optionextended_v_image_' + valueId).className = 'optionextended-picker-selected img-responsive';
  },
  
  unhighlightPickerImage : function(valueId){
    if (this.config[1][valueId][0]) 
      $('optionextended_v_image_' + valueId).className = 'optionextended-picker-unselected img-responsive';
  },
  
  showPickerImage : function(optionId, valueId){
    if ((this.config[0][optionId][1] == 'picker' || this.config[0][optionId][1] == 'pickerswap') && this.config[1][valueId][0])   
      $('optionextended_v_image_' + valueId).show();
  },  
  
  hidePickerImage : function(optionId, valueId){
    if ((this.config[0][optionId][1] == 'picker' || this.config[0][optionId][1] == 'pickerswap') && this.config[1][valueId][0]){      
      $('optionextended_v_image_' + valueId).hide();
    }
  },  
  
  
  
  reloadSelect : function(optionId, valueId){
    var select = $('select_' + optionId);
    for (var i=0; i < select.options.length; i++) {
       if (select.options[i].value == valueId) {
          select.options[i].selected = true;
          break;
       }
    } 
    optionExtended.observeSelectOne(select, optionId);
  },
  
  
  preloadSwapImages : function(optionIds, valsByOption){
    this.toload = 0;  
    this.loaded = 0;
    this.ss = '';
    var l = optionIds.length; 
    for (var i=0;i<l;i++){
      if (this.config[0][optionIds[i]][1] == 'swap' || this.config[0][optionIds[i]][1] == 'pickerswap'){
        var ll = valsByOption[optionIds[i]].length;
        while (ll--){
          if (this.config[1][valsByOption[optionIds[i]][ll]][0]){
            this.v[valsByOption[optionIds[i]][ll]].image = new Image();
            this.v[valsByOption[optionIds[i]][ll]].image.src = this.imageDirUrl + this.config[1][valsByOption[optionIds[i]][ll]][0];  
            this.v[valsByOption[optionIds[i]][ll]].image.onload = function(){
              this.loaded++;
              if (this.loaded == this.toload)
                this.onDataReady();
            }.bind(this);
            this.toload++;
          }   
        } 
      }
    } 
    if (this.toload == 0)
      this.onDataReady(); 
  },

  
  preloadPopupImages : function(optionIds, valsByOption){
    var l = optionIds.length; 
    for (var i=0;i<l;i++){
      if (this.config[0][optionIds[i]][2]){   
        var ll = valsByOption[optionIds[i]].length;
        while (ll--){
          if (this.config[1][valsByOption[optionIds[i]][ll]][0]){
            this.v[valsByOption[optionIds[i]][ll]].image = new Image();
            this.v[valsByOption[optionIds[i]][ll]].image.src = this.imageDirUrl + this.config[1][valsByOption[optionIds[i]][ll]][0];  
          }   
        } 
      }
    }   
  },  
  
  resetImage : function(optionId, valueId, type){
    if (this.config[0][optionId][1] == 'pickerswap'){ 
      this.unhighlightPickerImage(valueId);  
      this.hideImage(optionId, valueId, type);  
      this.hideDescription(optionId);
    } else if (this.config[0][optionId][1] == 'picker'){
      this.unhighlightPickerImage(valueId);
      this.hideDescription(optionId);
    } else {
      this.hideImage(optionId, valueId, type);  
      if ((this.config[0][optionId][1] == 'above' || this.config[0][optionId][1] == 'below') && (type == 'select-one' || type == 'radio')){
        this.hideDescription(optionId); 
      } else if (this.config[0][optionId][1] == 'before' && type == 'select-one' ){       
        this.hideDescriptionIcon(optionId);     
      }
      if (type == 'select-multiple')
        this.v[valueId].selected = false;           
    } 
  },  
  
  resetZoom : function(){
    if ($('track') && $('handle') && $('zoom_in') && $('zoom_out') && $('track_hint')){
      Event.stopObserving(this.mainImage,'dblclick');
      Event.stopObserving('zoom_in');
      Event.stopObserving('zoom_out');
      var parent = this.mainImage.parentNode;
      if (!Element.hasClassName(parent,'product-image-zoom')){
          $('track').up().show();
          $('track_hint').show();
          parent.addClassName('product-image-zoom');      
      }
      this.mainImage.style.width = 'auto';
      this.mainImage.style.height = 'auto';    
      new Product.Zoom(this.mainImage, 'track', 'handle', 'zoom_in', 'zoom_out', 'track_hint');
    }
  },
  
  
  makeImage : function(optionId, valueId, type){
    var element,className,onclick,src,style,title,id; 
    switch (this.config[0][optionId][1]){
      case 'above' :
      case 'below' :      
        id = type == 'one' ? 'optionextended_image_' + optionId : 'optionextended_v_image_' + valueId;                
        className  = 'optionextended-image';
        style = 'display:none;';        
        if (valueId && this.config[1][valueId][0]){
          src  = this.thumbnailDirUrl + this.config[1][valueId][0];
          if (this.config[0][optionId][2]){
            style += 'cursor:pointer;'; 
            title = this.imageTitle;
            onclick = this.imagePopupTemplate.evaluate({'url' : '\'' + this.imageDirUrl + this.config[1][valueId][0] + '\''});          
          }
        } else if (valueId){
          src = this.placeholderUrl;          
        } else {
          src = this.spacer;            
        }         
      break;        
      case 'grid' :
      case 'list' :
        className = 'optionextended-image';
        if (valueId && this.config[1][valueId][0]){
          src  = this.thumbnailDirUrl + this.config[1][valueId][0];
          if (this.config[0][optionId][2]){
            style = 'cursor:pointer;';  
            title = this.imageTitle;
            onclick = this.imagePopupTemplate.evaluate({'url' : '\'' + this.imageDirUrl + this.config[1][valueId][0] + '\''});          
          }
        } else if (valueId){
          src = this.placeholderUrl;          
        } else {
          src = this.spacer;            
        }     
        if (!this.config[0][optionId][2])
          onclick = 'optionExtended.actAsLabel(' + optionId + ', ' + valueId + ')';       
      break;
      case 'before' :       
        id = 'optionextended_image_' + optionId;
        className  = 'optionextended-image';        
        src  = !valueId ? this.spacer : (!this.config[1][valueId][0] ? this.placeholderUrl : this.thumbnailDirUrl + this.config[1][valueId][0]);
      break;
      case 'pickerswap' :               
      case 'picker' :   
        id = 'optionextended_v_image_' + valueId;
        className = 'optionextended-picker-unselected  img-responsive';
        src = this.pickerImageDirUrl + this.config[1][valueId][0];        
        onclick = 'optionExtended.reloadSelect(' + optionId + ', ' + valueId + ')';     
      break;
    }     
    
    element = '<img src="'+src+'" class="'+className+'"' + (id ? ' id="'+id+'"' : '') + (style ? ' style="'+style+'"' : '') + (title ? ' title="'+title+'"' : '') + (onclick ? ' onclick="'+onclick+'"' : '') + '/>';             

    return element;
  },
  
  actAsLabel : function(optonId, valueId){  
    element = valueId ? this.oldV[valueId].element : $('options_'+optonId);
    if (element.type == 'radio'){
      element.checked |= true;
      this.observeRadio(optonId, element.value);
    } else {
      element.checked = !element.checked;    
      this.observeCheckbox(element, optonId, element.value); 
    }
    opConfig.reloadPrice();
  } 

});
