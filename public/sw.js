self.addEventListener('install', event => {
    console.log('install', event)
})
self.addEventListener('activate', event => {
    console.log('activate', event)
})
self.addEventListener('message', event => {
    // console.log('message', event)
})
self.addEventListener('fetch', event => {
    // console.log('fetch', event)
})
self.addEventListener('sync', event => {
    // console.log('sync', event)
})
self.addEventListener('push', event => {
    // console.log('push', event)
})