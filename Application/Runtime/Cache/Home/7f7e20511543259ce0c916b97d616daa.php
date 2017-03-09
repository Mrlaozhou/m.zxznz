<?php if (!defined('THINK_PATH')) exit(); require_once('/Public/Home/header.html');?>





<div class="connect">
	<div class="connect-top">
		<img style="width:100%;height:230px;" src="/Public/Home/images/connect-bg.jpg">
	</div>
	<div class="connect-content">
		<div class="connect-fixed">
			<ul style="width:600px;height:300px;padding:20px 0;margin:20px auto;">
				<li>
					<div style="text-align:center;">
						<img style="width:30px;height:30px;" src="/Public/Home/images/tel.png">
					</div>
					<p>
						Tel：4000-21-4000
					</p>
				</li>
				<li>
					<div style="text-align:center;">
						<img style="width:30px;height:30px;" src="/Public/Home/images/email.png">
					</div>
					<p>
						E-mail：zxznzcn@163.com
					</p>
				</li>
				<li>
					<div style="text-align:center;">
						<img style="width:30px;height:30px;" src="/Public/Home/images/www.png">
					</div>
					<p>
						Wechat：zxznz-cn 
					</p>
				</li>
				<li>
					<div style="text-align:center;">
						<img style="width:30px;height:30px;" src="/Public/Home/images/address.png">
					</div>
					<p>
						Address：上海市陕西北路1438号财富时代大厦25层
					</p>
				</li>
			</ul>
		</div>
		<div class="connect-empty">

		</div>
		<div class="connect-map">
			<style>
				body { margin: 0; font: 13px/1.5 "Microsoft YaHei", "Helvetica Neue", "Sans-Serif"; min-height: 960px; min-width: 600px; }
				.my-map { margin: 0 auto; width: 1440px; height: 400px; }
				.my-map .icon { background: url(http://lbs.amap.com/console/public/show/marker.png) no-repeat; }
				.my-map .icon-cir { height: 31px; width: 28px; }
				.my-map .icon-cir-red { background-position: -11px -5px; }
				.amap-container{height: 100%;}
			</style>

			<div id="wrap" class="my-map">
				<div id="mapContainer"></div>
			</div>
			<script src="http://webapi.amap.com/maps?v=1.3&key=8325164e247e15eea68b59e89200988b"></script>
			<script>
			!function(){
				var infoWindow, map, level = 14,
					center = {lng: 121.447645, lat: 31.246133},
					features = [{type: "Marker", name: "", desc: "", color: "red", icon: "cir", offset: {x: -9, y: -31}, lnglat: {lng: 121.444083, lat: 31.244299}}];

				function loadFeatures(){
					for(var feature, data, i = 0, len = features.length, j, jl, path; i < len; i++){
						data = features[i];
						switch(data.type){
							case "Marker":
								feature = new AMap.Marker({ map: map, position: new AMap.LngLat(data.lnglat.lng, data.lnglat.lat),
									zIndex: 3, extData: data, offset: new AMap.Pixel(data.offset.x, data.offset.y), title: data.name,
									content: '<div class="icon icon-' + data.icon + ' icon-'+ data.icon +'-' + data.color +'"></div>' });
								break;
							case "Polyline":
								for(j = 0, jl = data.lnglat.length, path = []; j < jl; j++){
									path.push(new AMap.LngLat(data.lnglat[j].lng, data.lnglat[j].lat));
								}
								feature = new AMap.Polyline({ map: map, path: path, extData: data, zIndex: 2,
									strokeWeight: data.strokeWeight, strokeColor: data.strokeColor, strokeOpacity: data.strokeOpacity });
								break;
							case "Polygon":
								for(j = 0, jl = data.lnglat.length, path = []; j < jl; j++){
									path.push(new AMap.LngLat(data.lnglat[j].lng, data.lnglat[j].lat));
								}
								feature = new AMap.Polygon({ map: map, path: path, extData: data, zIndex: 1,
									strokeWeight: data.strokeWeight, strokeColor: data.strokeColor, strokeOpacity: data.strokeOpacity,
									fillColor: data.fillColor, fillOpacity: data.fillOpacity });
								break;
							default: feature = null;
						}
						if(feature){ AMap.event.addListener(feature, "click", mapFeatureClick); }
					}
				}

				function mapFeatureClick(e){
					if(!infoWindow){ infoWindow = new AMap.InfoWindow({autoMove: true}); }
					var extData = e.target.getExtData();
					infoWindow.setContent("<h5>" + extData.name + "</h5><div>" + extData.desc + "</div>");
					infoWindow.open(map, e.lnglat);
				}

				map = new AMap.Map("mapContainer", {center: new AMap.LngLat(center.lng, center.lat), level: level});
				
				loadFeatures();	}();
			</script>
		</div>
	</div>
</div>
















<?php require_once('/Public/Home/footer.html');?>