(function($){
    jQuery.fn.Geodata = function(options){
        var _defaults = {width: '350px', height: '350px', no_scroll_zoom: 0};

        var options = $.extend(true, _defaults, options);
        options.yandex_map_version='2';
        if(typeof yandex_map_version != 'undefined'){
            options.yandex_map_version=yandex_map_version;
        }
        
        var PositionEditorLeaflet={
            init: function(map){
                this.map=map;
                this.settedMarker=null;
                return this;
            },
            initMarker: function(x,y,id){
                if(x!='' && y!=''){
                    var latlng = [Number(x), Number(y)];
                    this.createPositionMarker(latlng, id);
                    this.map.setView(latlng);
                }else{
                    if(this.settedMarker!=null){
                        this.map.removeLayer(this.settedMarker);
                        this.settedMarker=null;
                    }
                }

            },

            createPositionMarker: function(latlng, id){
                var lat=new String(latlng.lat);
                var lng=new String(latlng.lng);
                var lat_parts=lat.split('.');
                if(lat_parts[1]!==undefined && lat_parts[1].length>6){
                    lat=lat_parts[0]+'.'+lat_parts[1].substring(0,6);
                }
                var lng_parts=lng.split('.');
                if(lng_parts[1]!==undefined && lng_parts[1].length>6){
                    lng=lng_parts[0]+'.'+lng_parts[1].substring(0,6);
                }

                if(this.settedMarker!=null){
                    this.map.removeLayer(this.settedMarker);
                    this.settedMarker=null;
                }
                
                var marker = L.marker(latlng).addTo(this.map);

               
                this.settedMarker=marker;
                var ret=[];
                ret.push(lat);
                ret.push(lng);
                return ret;
            }
        }

        var PositionEditor={
            init: function(map){
                this.map=map;
                this.settedMarker=null;
            },
            initMarker: function(x,y,id){
                if(x!='' && y!=''){
                    var latlng = new google.maps.LatLng(Number(x), Number(y));
                    this.createPositionMarker(latlng,id);
                    this.map.setCenter(latlng);
                }else{
                    if(this.settedMarker!=null){
                        this.settedMarker.setMap(null);
                        this.settedMarker=null;
                    }
                }

            },

            createPositionMarker: function(latlng, id){

                var lat=new String(latlng.lat());
                var lng=new String(latlng.lng());
                var lat_parts=lat.split('.');
                if(lat_parts[1]!==undefined && lat_parts[1].length>6){
                    lat=lat_parts[0]+'.'+lat_parts[1].substring(0,6);
                }
                var lng_parts=lng.split('.');
                if(lng_parts[1]!==undefined && lng_parts[1].length>6){
                    lng=lng_parts[0]+'.'+lng_parts[1].substring(0,6);
                }

                if(this.settedMarker!=null){
                    this.settedMarker.setMap(null);
                    this.settedMarker=null;
                }

                var marker = new google.maps.Marker({
                    position: latlng, 
                    map: this.map,
                    draggable: false,
                    title:latlng.lat()+' '+latlng.lng()
                });
                this.settedMarker=marker;
                var ret=[];
                ret.push(lat);
                ret.push(lng);
                return ret;
            }
        }
        var PositionEditorYandex={
            init: function(map){
                this.map=map;
                this.settedMarker=null;
            },
            initMarker: function(x, y, id){
                if(x!='' && y!=''){
                    //var latlng = new google.maps.LatLng(new Number(x),new Number(y));
                    var latlng=new Array(new Number(x),new Number(y));
                    this.createPositionMarker(latlng, id);
                    this.map.setCenter(latlng);
                }else{
                    if(this.settedMarker!=null){
                        this.settedMarker.setMap(null);
                        this.settedMarker=null;
                    }
                }

            },

            createPositionMarker: function(latlng, id){

                var lat=new String(latlng[0]);
                var lng=new String(latlng[1]);
                /*var lat=latlng[0].toPrecision(8);
                var lng=latlng[1].toPrecision(8);*/
                var lat_parts=lat.split('.');
                if(lat_parts[1]!==undefined && lat_parts[1].length>6){
                    lat=lat_parts[0]+'.'+lat_parts[1].substring(0,6);

                }
                var lng_parts=lng.split('.');
                if(lng_parts[1]!==undefined && lng_parts[1].length>6){
                    lng=lng_parts[0]+'.'+lng_parts[1].substring(0,6);
                }

                if(this.settedMarker!=null){
                    this.map.geoObjects.remove(this.settedMarker);
                    this.settedMarker=null;
                }
                var myPlacemark = new ymaps.Placemark(
                    latlng,
                    {iconContent: ''},
                    {draggable: false}
                );
                this.map.geoObjects.removeAll();
                this.map.geoObjects.add(myPlacemark);


                this.settedMarker=myPlacemark;
                var ret=[];
                ret.push(lat);
                ret.push(lng);
                return ret;
            }
        }
        var GDC=$(this);

        var parent_form=GDC.parents('form').eq(0);


        var map_id=GDC.attr('id').replace('geodata_', 'geodata_map_');


        var map_center_string=GDC.attr('coords');
        var map_zoom=GDC.attr('zoom');

        if(map_zoom=='' || map_zoom=='0'){
            map_zoom=Number(10);
        }else{
            map_zoom=Number(map_zoom);
        }

        if(map_center_string!=''){
            var c=map_center_string.split(',');
        }else{
            var c=[55.751849,37.622681];
        }


        var late=GDC.find('[geodata=lat]');
        var lnge=GDC.find('[geodata=lng]');


        if(options.map_type!='google' && options.map_type!='leaflet_osm'){
            options.map_type='yandex';
        }

        if(options.map_type=='google'){
            if(typeof google === 'object'){
                if(late && lnge){
                    //var map_id='map_'+CryptoJS.MD5((new Date()).toString()+'_'+(Math.floor(Math.random() * (999 - 100 + 1)) + 100));
                    var map=initializeGoogleLocationsMap(map_id);

                    var PE=PositionEditor.init(map);
                    google.maps.event.addDomListener(map, 'click', function(event) {
                        var geo_c=PositionEditor.createPositionMarker(event.latLng, 0);
                        late.val(geo_c[0]);
                        lnge.val(geo_c[1]);
                    });
                    var lat=late.val();
                    var lng=lnge.val();
                    if(lat!='' && lng!=''){
                        PositionEditor.initMarker(lat, lng, 0);
                    }

                    late.change(function(){
                        var lng=lnge.val();
                        var lat=late.val();
                        if(lat!='' && lng!=''){
                            runMapChange(map, lat, lng);
                            PositionEditor.initMarker(lat, lng, 0);
                        }
                    });

                    lnge.change(function(){
                        var lng=lnge.val();
                        var lat=late.val();
                        if(lat!='' && lng!=''){
                            runMapChange(map, lat, lng);
                            PositionEditor.initMarker(lat, lng, 0);
                        }
                    });
                }
            }

        }else if(options.map_type=='leaflet_osm'){
            
            
            if(late && lnge){
                var map=initializeLeafletOSMLocationsMap(map_id);
                var PE=PositionEditorLeaflet.init(map);
                map.on('click', function (e) {
                    
                    var l=e.latlng;

                    var geo_c=PE.createPositionMarker(l, 0);
                    late.val(geo_c[0]);
                    lnge.val(geo_c[1]);
                });
                var lat=late.val();
                var lng=lnge.val();
                
                if(lat!='' && lng!=''){
                    PE.initMarker(lat, lng, 0);
                }
                
                late.change(function(){

                    var lng=lnge.val();
                    var lat=late.val();
                    //if(lat!='' && lng!=''){
                        runMapChange(map, lat, lng);
                        PE.initMarker(lat, lng, 0);
                    //}
                });

                lnge.change(function(){

                    var lng=lnge.val();
                    var lat=late.val();
                    if(lat!='' && lng!=''){
                        runMapChange(map, lat, lng);
                        PE.initMarker(lat, lng, 0);
                    }
                });
            }
            
           
        }else{
            if(late && lnge){
                //var map_id='map_'+CryptoJS.MD5((new Date()).toString()+'_'+(Math.floor(Math.random() * (999 - 100 + 1)) + 100));
                ymaps.ready(function(){
                    var map=initializeYandexLocationsMap(map_id);
                    var PE=PositionEditorYandex.init(map);
                    map.events.add('click', function (e) {
                        var geo_c=PositionEditorYandex.createPositionMarker(e.get('coords'), 0);
                        late.val(geo_c[0]);
                        lnge.val(geo_c[1]);
                    });
                    var lat=late.val();
                    var lng=lnge.val();
                    if(lat!='' && lng!=''){
                        PositionEditorYandex.initMarker(lat, lng, 0);
                    }


                    late.change(function(){

                        var lng=lnge.val();
                        var lat=late.val();
                        if(lat!='' && lng!=''){
                            runMapChange(map, lat, lng);
                            //PositionEditor.init(map);
                            PositionEditorYandex.initMarker(lat, lng, 0);
                        }
                    });

                    lnge.change(function(){

                        var lng=lnge.val();
                        var lat=late.val();
                        if(lat!='' && lng!=''){
                            runMapChange(map, lat, lng);
                            //PositionEditor.init(map);
                            PositionEditorYandex.initMarker(lat, lng, 0);
                        }
                    });
                });

            }
        }

        function runMapChange(map, lat, lng){
            if(options.map_type=='google'){
                map.panTo(new google.maps.LatLng(lat,lng));
                //map.setCenter(new google.maps.LatLng(lat, lng));
                //map.panTo(new google.maps.LatLng(lat, lng));
            }else if(options.map_type=='leaflet_osm'){
                map.setView(new Array(lat, lng));
            }else{
                //map.setCenter(new Array(lat, lng));
                map.panTo(new Array(lat, lng));
            }
        }

        function initializeYandexLocationsMap(map_id){
            var behaviors=[];
            behaviors.push("drag");
            behaviors.push("dblClickZoom");
            if(options.no_scroll_zoom==0 && $(window).width()>800){
                behaviors.push("scrollZoom");
            }

            var controls = [];
            controls.push('smallMapDefaultSet');
            controls.push('searchControl');

            var latlng=new Array(Number(c[0]), Number(c[1]));
            var m=$('<div id="'+map_id+'" style="width:'+options.width+'; height:'+options.height+'"></div>')
            m.appendTo($('body')).css({'position':'absolute','left':'-1000px','display':'block'});
            if(options.map_view_type=='m'){
                var map_view_type='yandex#map';
            }else if(options.map_view_type=='h'){
                var map_view_type='yandex#hybrid';
            }else if(options.map_view_type=='s'){
                var map_view_type='yandex#satellite';
            }else if(options.map_view_type=='p'){
                var map_view_type='yandex#publicMap';
            }else{
                var map_view_type='yandex#map';
            }

            if(options.yandex_map_version=='2'){
                var map = new ymaps.Map(document.getElementById(map_id), {
                    zoom: map_zoom,
                    center: latlng,
                    behaviors: behaviors,
                    type : map_view_type
                });
                map.controls.add(new ymaps.control.TypeSelector(['yandex#map', 'yandex#publicMap', 'yandex#satellite', 'yandex#hybrid']));
                map.controls.add('scaleLine');
                map.controls.add('zoomControl', { top: 75, left: 5 });
            }else{
                var map = new ymaps.Map(document.getElementById(map_id), {
                    zoom: map_zoom,
                    center: latlng,
                    behaviors: behaviors,
                    type : map_view_type,
                    controls: controls
                },{suppressMapOpenBlock: true});
                map.controls.remove('searchControl'); // сделать условным
                map.controls.remove('geolocationControl');
                map.controls.remove('fullscreenControl');

                var searchControl = new ymaps.control.SearchControl({
                    options: {
                        provider: 'yandex#map',
                        noPlacemark: true
                    }
                });

                map.controls.add(searchControl);

                searchControl.events.add('resultselect', function(e) {
                    var index = e.get('index');
                    searchControl.getResult(index).then(function(res) {
                        // Получаем метаданные
                        var GeocoderMetaData = res.properties.get('metaDataProperty').GeocoderMetaData;

                        // Выводим название локации???
                        //GDC.find('.geodata_form_name').text(GeocoderMetaData.text); // вывод локации

                        // Сохраняем меьтаданные в какое-то поле для отправки???
                        // Или отправляем в фоне???
                        // Или подобно dadata расставляем по форме???
                        //GDC.find('[name=geodata]').val(JSON.stringify(res.properties._data.metaDataProperty)); // отправка расширенных данных

                        //Ставим маркер
                        var geo_c=PositionEditorYandex.createPositionMarker(res.geometry.getCoordinates(), 0);
                        late.val(geo_c[0]);
                        lnge.val(geo_c[1]);

                    });
                })
            }
            //m.css({'position':'relative','left':'0'}).appendTo(GDC.find('.geodata_map_holder'));
            var w=GDC.find('.geodata_map_holder').width();
            var h=GDC.find('.geodata_map_holder').height();
            
            
            /*if(options.yandex_map_version=='2.1'){
                map.events.add('tilesLoaded', function () {
                    map.container.fitToViewport();
                })
            }else{
                map.container.fitToViewport();
            }*/
            
            let timerId = setInterval(function(){if(GDC.find('.geodata_map_holder').is(':visible')){clearInterval(timerId);m.css({'position':'relative','left':'0', 'width':w, 'height':options.height}).appendTo(GDC.find('.geodata_map_holder'));map.container.fitToViewport();}else{}}, 1000);
            return map;	
        }
        
        function initializeLeafletOSMLocationsMap(map_id){
            var latlng = [Number(c[0]), Number(c[1])];
            /*if(options.no_scroll_zoom==1 || (options.no_scroll_zoom==0 && $(window).width()>800)){
                myOptions.scrollwheel=false;
            }*/

            var m=$('<div id="'+map_id+'" style="width:'+options.width+'; height:'+options.height+'"></div>')
            m.css({'position':'relative','left':'0', 'width':options.width, 'height':options.height}).appendTo(GDC.find('.geodata_map_holder'));
            var map = L.map(map_id).setView(latlng, 9);
            
            var osmUrl='https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            var osmAttrib='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
            var osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});
            
            map.addLayer(osm);

            return map;
        }

        function initializeGoogleLocationsMap(map_id){

            var latlng = new google.maps.LatLng(Number(c[0]), Number(c[1]));
            if(options.map_view_type=='m'){
                var map_view_type=google.maps.MapTypeId.ROADMAP;
            }else if(options.map_view_type=='h'){
                var map_view_type=google.maps.MapTypeId.HYBRID;
            }else if(options.map_view_type=='s'){
                var map_view_type=google.maps.MapTypeId.SATELLITE;
            }else{
                var map_view_type=google.maps.MapTypeId.ROADMAP;
            }
            var map_view_type1=google.maps.MapTypeId.SATELLITE;
            var myOptions = {
                zoom: map_zoom,
                center: latlng,
                streetViewControl: false,
                mapTypeId: map_view_type1
            };

            if(options.no_scroll_zoom==1 || (options.no_scroll_zoom==0 && $(window).width()>800)){
                myOptions.scrollwheel=false;
            }

            var m=$('<div id="'+map_id+'" style="width:'+options.width+'; height:'+options.height+'"></div>')
            m.appendTo($('body')).css({'position':'absolute','left':'-1000px','display':'block'});
            var map = new google.maps.Map(document.getElementById(map_id), myOptions);

            google.maps.event.addDomListener(map, 'tilesloaded', function(event) {
                if(map_view_type1!=map_view_type){
                    map.setOptions({mapTypeId: map_view_type});
                }
                m.css({'position':'relative','left':'0', 'width':options.width, 'height':options.height}).appendTo(GDC.find('.geodata_map_holder'));
                google.maps.event.clearListeners(map, 'tilesloaded');
                google.maps.event.trigger(map, "resize");
            });

            return map;
        }

        function georun(str){
            $.ajax({
                url: estate_folder+'/apps/geodata/js/ajax.php',
                dataType: 'json',
                data: {action: 'geocode_fast', input: str},
                success: function(json){
                    if(json.lat !== undefined && json.lng !== undefined){
                        $('form input[geodata=lat]').val(json.lat).trigger('change');
                        $('form [geodata=lng]').val(json.lng).trigger('change');
                    }
                }
            });
        }

        if(options.confields.length>0 && parent_form.legth!=0){
            var prev_els_array=[];
            for(var i=0; i<options.confields.length; i++){
                prev_els_array[options.confields[i]]=options.confields.slice(0, i+1);

                var element_for_event='[name='+options.confields[i]+']';
                /*if(parent_form.find(element_for_event).parents('.geoautocomplete_block').length>0){
                    element_for_event='[name=geoautocomplete\\['+options.confields[i]+'\\]]';
                    console.log(element_for_event);
                }*/

                /*if(parent_form.find(element_for_event).parents('.geoautocomplete_block').length>0){
                    console.log(options.confields[i]);
                    parent_form.on('change', '[name=geoautocomplete\['+options.confields[i]+'\]]', function(){
                        var $this=$(this);
                        var name=this.name;
                        //console.log(name);
                        var n=[];
                        for(var k=0; k<prev_els_array[name].length; k++){
                            var el=parent_form.find('[name='+prev_els_array[name][k]+']');
                            if(el.prop("tagName").toLowerCase()=='select'){
                                if(el.val()!=0){
                                    n.push(el.find('option:selected').text());
                                }
                            }else if(el.prop("tagName").toLowerCase()=='input'){
                                console.log(el);
                                if(el.parents('.geoautocomplete_block').length>0){
                                    if(el.parents('.geoautocomplete_block').find('.geoautocomplete').eq(0).val()!=''){
                                        n.push(el.parents('.geoautocomplete_block').find('.geoautocomplete').eq(0).val());
                                    }
                                }else if(el.val()!=''){
                                    n.push(el.val());
                                }

                            }
                        }
                        //if(prev_fixed_val!=)
                        georun(n.join(','));
                    });
                }else{

                }*/
                /*if(parent_form.find(element_for_event).parents('.geoautocomplete').length>0){
                    element_for_event='[name=geoautocomplete\['+options.confields[i]+'\]]';
                }*/
                //console.log(parent_form.find(element_for_event).parents('.geoautocomplete'));

                parent_form.on('change', element_for_event, function(){
                    var $this=$(this);
                    var name=this.name;

                    var n=[];

                    for(var k=0; k<prev_els_array[name].length; k++){
                        var el=parent_form.find('[name='+prev_els_array[name][k]+']');
                        if(el.prop("tagName").toLowerCase()=='select'){
                            if(el.val()!=0){
                                n.push(el.find('option:selected').text());
                            }
                        }else if(el.prop("tagName").toLowerCase()=='input'){
                            //console.log(el);
                            if(el.parents('.geoautocomplete_block').length>0){
                                if(el.parents('.geoautocomplete_block').find('.geoautocomplete').eq(0).val()!=''){
                                    n.push(el.parents('.geoautocomplete_block').find('.geoautocomplete').eq(0).val());
                                }
                            }else if(el.val()!=''){
                                n.push(el.val());
                            }

                        }
                    }
                    //if(prev_fixed_val!=)
                    georun(n.join(','));
                });
            }
        }
    };
})(jQuery);