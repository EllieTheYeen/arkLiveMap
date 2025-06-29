

function wsconnect(url, wsp) {
  if (!wsp) {
    wsp = { retry: true, backoff: 1 };
    console.log("new context", wsp)
  } else {
    console.log("passed context", wsp)
  }
  var ws = new WebSocket(url);
  ws.onclose = () => {
    console.log(`WebSocket connection lost`);
    if (wsp.retry) {
      setTimeout(() => wsconnect(url, wsp), wsp.backoff * 1000);
    }
    wsp.onclose = null;
  };
  ws.onerror = (ev) =>{
    wsp.backoff = wsp.backoff * 2 + Math.random() * 3;
    if (wsp.backoff > 120) {
      wsp.backoff = 120;
    }
    console.log(`WebSocket Error Retrying in ${wsp.backoff}`);
    if (wsp.onclose) {
      wsp.onclose(ev);
    }
  };
  ws.onopen = (ev) => {
    console.log(`WebSocket connected`);
    wsp.backoff = 1;
    if (wsp.onopen) {
      wsp.onopen(ev);
    }
  };
  ws.onmessage = (msg) => {
    console.log(`WebSocket recieved ${msg.data}`);
    if (wsp.onmessage) {
      wsp.onmessage(msg);
    }
  }
  wsp.send = (msg) => {
    console.log(`WebSocket sending ${msg}`);
    ws.send(msg);
  }
  return wsp;
}

var ws = wsconnect("wss://kserver.nu/arkmapws");

ws.onmessage = function (event) {
  console.log('ws onmessage');
  var json = JSON.parse(event.data);
  if (typeof (json.id) != 'undefined') {
    id = json.id;
    let temp = window.location.href;
    temp = temp.split('/');
    let server_id = temp[temp.length - 1];
    ws.send(JSON.stringify({ server_id: server_id }));
  } else if (typeof (json.marker) != 'undefined') {
    markerClusters.clearLayers(); // Clear all markers on map
    playerLayer.clearLayers();
    tribeLayer.clearLayers();
    // Players:
    mark = json.marker;
    markerLength = mark.length;
    for (i = 0; i < markerLength; i++) {
      var m = L.marker([100 - parseFloat(mark[i][1]), parseFloat(mark[i][0])], {
        icon: L.AwesomeMarkers.icon({
          icon: mark[i][2],
          prefix: 'fa',
          markerColor: mark[i][3]
        })
      }).bindPopup(mark[i][4] + '<br />cheat setplayerpos ' + Math.trunc(mark[i][6]) + ' ' + Math.trunc(mark[i][7]) + ' ' + (parseInt(Math.trunc(mark[i][8])) + parseInt(1000)) + '<br />' + mark[i][5]);
      markerClusters.addLayer(m);
      playerLayer.addLayer(m);
    }
    // Tribes:
    tribe_mark = json.tribe_markers;
    markerLength = tribe_mark.length;
    for (i = 0; i < markerLength; i++) {
      var m = L.marker([100 - parseFloat(tribe_mark[i][1]), parseFloat(tribe_mark[i][0])], {
        icon: L.AwesomeMarkers.icon({
          icon: tribe_mark[i][2],
          prefix: 'fa',
          markerColor: tribe_mark[i][3]
        })
      }).bindPopup(tribe_mark[i][4] + '<br />cheat setplayerpos ' + Math.trunc(tribe_mark[i][6]) + ' ' + Math.trunc(tribe_mark[i][7]) + ' ' + (parseInt(Math.trunc(tribe_mark[i][8])) + parseInt(1000)) + '<br />' + (tribe_mark[i][9]).toFixed(2) + ' days not updated');
      markerClusters.addLayer(m);
      tribeLayer.addLayer(m);
    }
  }
  // After everything was updated update the time
  if (typeof (json.serverclock) == 'undefined') {
    document.getElementById("clock").innerHTML = 'Day ?, ??:??:??';
  } else {
    console.log('clock set now!');
    document.getElementById("clock").innerHTML = json.serverclock;
  }
}
