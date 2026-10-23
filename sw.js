var CACHE_STATIC_NAME = 'static-v1';
var CACHE_DYNAMIC_NAME = 'dynamic-v1';

self.addEventListener('install', function(event) {
  console.log('[Service Worker] Installing Service Worker ...', event);
  event.waitUntil(
    caches.open(CACHE_STATIC_NAME)
      .then(function(cache) {
        console.log('[Service Worker] Precaching App Shell');
       return cache.addAll([
          '/',
          'css/bootstrap.min.css',
          'font-awesome/css/font-awesome.min.css',
          'vendor/css/style.css',
          'js/jquery.js',
          'js/app.js',
          'js/dexie.js',    
          'js/popper.min.js',
          'js/bootstrap.min.js',
          'actividad.html',
          'bajar_bd.php',
          'checklogin.php',
          'conexion.php',
          'credencial.html',
          'datos_tienda.html',
          'documentos.html',
          'error.html',  
          'historial.html',   
          'login.php',   
          'inicio.html',      
          'manifest.json', 
          'precargado_tiendas.html',    
          'programa.html',   
          'sincronizar_entregable.php',
          'sincronizar_misiones.php',
          'sw.js',
          'tiendas.html',
          'visita_iniciada.html',
          'visita_iniciada_obj.html',
          'xd/alerta.png', 
          'xd/check.png',
          'xd/card_right.png',
          'xd/card_up.png',
          'xd/linea_azul.png',
          'xd/nocheck.png',
          'xd/objetivos.png',
          'xd/over.png',
          'xd/pausa.png',
          'xd/perfil.png',
          'xd/perfil_bco.png',   
          'xd/pestana_iniciada.png',
          'xd/pestana_objetivo.png',   
          'xd/reiniciar.png',
          'xd/sos.png',
          'xd/tiendas.png'
        ]);
      })
  )
});

self.addEventListener('activate', function(event) {
  console.log('[Service Worker] Activating Service Worker ....', event);
  event.waitUntil(
    caches.keys()
      .then(function(keyList) {
        return Promise.all(keyList.map(function(key) {
          if (key !== CACHE_STATIC_NAME && key !== CACHE_DYNAMIC_NAME) {
            console.log('[Service Worker] Removing old cache.', key);
            return caches.delete(key);
          }
        }));
      })
  );
  return self.clients.claim();
});



// este ya jalo su sistema es web -  cache estatica, guarda en dinamica onreload y enseña, offline cache
self.addEventListener('fetch', function(event) {
  event.respondWith(
    fetch(event.request) //busca en la web
      .then(function(res) { // si lo encuentra en web
        return caches.open(CACHE_DYNAMIC_NAME) //abre cache 
                .then(function(cache) { // y lo guarda
                  cache.put(event.request.url, res.clone());
                 return res;
                })
      })
      .catch(function(err) { //si no lo encuentra en web
        return caches.match(event.request) // lo jala de cache
              .then(function(res) {
                if (res){ //si lo encontro
                    return res; // enseñalo
                }else{
                    return caches.match('error.html');  //si no lo encontro pagina de error
                }
             
            });
              
      })
  );
});