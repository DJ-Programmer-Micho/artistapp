<div>


  <script src="{{asset('assets/js/jsvectormap.js')}}"></script>
  <script src="{{asset('assets/js/world-merc.js')}}"></script>
    <style>
      #map {
        border: 2px solid white;
        background-color: #49b9d4 !important;
      }
      .jvm-tooltip {
        /* display: none; */
      }
      .jvm-tooltip h5,
      .jvm-tooltip p {
        margin: 4px;
      }
      .jvm-tooltip {
        /* background-color: #cc0022; */
      }
    </style>
    <div id="map" style="width: 100%; height:80vh "></div>
  </div>
  @script
  <script>
  
  
    $wire.on('fetchGeoChartData', function (event) {
      const geoData = event[0].geoData;
      initializeMap(geoData);
    });
  </script>
  @endscript
  <script>
    let mapInstance;
  
    function initializeMap(geoData) {
      if (mapInstance) {
        mapInstance.destroy();
      }
  
      let values = {};
      geoData.forEach((country) => {
        values[country.code] = country.listeners; // Use raw numbers here
      });
  
      mapInstance = new jsVectorMap({
        map: "world_merc",
        selector: "#map",
        zoomButtons: false,
        zoomOnScroll: true,
        visualizeData: {
          scale: ["#e5fae1", "#ff0000"],
          values: values, // Raw numbers here
        },
        regionStyle: {
          hover: { fill: "#ff0000" },
          initial: {
            fill: "#333435",
            stroke: "#676767",
            strokeWidth: 0.5,
            fillOpacity: 1,
          },
        },
        labels: {
          regions: {
            render: (code) => {
              const country = geoData.find((c) => c.code === code);
              return country ? `${country.formatted_listeners} ${country.code}` : null; // Use formatted number for display
            },
          },
        },
        onRegionTooltipShow: function (event, tooltip, code) {
          const country = geoData.find((c) => c.code === code);
          if (country) {
            tooltip.text(
              `<p>${tooltip.text()} - ${country.code}</p>` +
              `<p>Listeners: ${country.listeners}</p>`, // Use formatted number for tooltip
              true
            );
          }
        },
      });
    }
  </script>
  
  