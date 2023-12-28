const Ziggy = {"url":"https:\/\/magenta-database.eu-1.sharedwithexpose.com","port":null,"defaults":{},"routes":{"index":{"uri":"\/","methods":["GET","HEAD"]},"settings":{"uri":"settings","methods":["GET","HEAD"]},"songs.index":{"uri":"songs","methods":["GET","HEAD"]},"songs.create":{"uri":"songs\/create","methods":["GET","HEAD"]},"songs.store":{"uri":"songs","methods":["POST"]},"songs.edit":{"uri":"songs\/{song}\/edit","methods":["GET","HEAD"],"bindings":{"song":"id"}},"songs.update":{"uri":"songs\/{song}","methods":["PUT","PATCH"],"bindings":{"song":"id"}},"songs.destroy":{"uri":"songs\/{song}","methods":["DELETE"],"bindings":{"song":"id"}},"songs.edit-relations":{"uri":"songs\/{song}\/edit\/relations","methods":["GET","HEAD"],"bindings":{"song":"id"}},"songs.update-relations":{"uri":"songs\/{song}\/relations","methods":["PUT"],"bindings":{"song":"id"}},"songs.medias.create":{"uri":"songs\/{song}\/medias\/create","methods":["GET","HEAD"],"bindings":{"song":"id"}},"songs.medias.store":{"uri":"songs\/{song}\/medias","methods":["POST"],"bindings":{"song":"id"}},"songs.medias.destroy":{"uri":"songs\/{song}\/medias\/{media}","methods":["DELETE"],"bindings":{"song":"id","media":"id"}},"songs.files.create":{"uri":"songs\/{song}\/files\/create","methods":["GET","HEAD"],"bindings":{"song":"id"}},"songs.files.store":{"uri":"songs\/{song}\/files","methods":["POST"],"bindings":{"song":"id"}},"songs.show":{"uri":"songs\/{song}","methods":["GET","HEAD"],"wheres":{"song":".{26}"},"bindings":{"song":"id"}},"songs.browse":{"uri":"songs\/browse\/{filter?}","methods":["GET","HEAD"]},"albums.index":{"uri":"albums","methods":["GET","HEAD"]},"albums.create":{"uri":"albums\/create","methods":["GET","HEAD"]},"albums.store":{"uri":"albums","methods":["POST"]},"albums.show":{"uri":"albums\/{album}","methods":["GET","HEAD"],"bindings":{"album":"id"}},"albums.edit":{"uri":"albums\/{album}\/edit","methods":["GET","HEAD"],"bindings":{"album":"id"}},"albums.update":{"uri":"albums\/{album}","methods":["PUT","PATCH"],"bindings":{"album":"id"}},"albums.destroy":{"uri":"albums\/{album}","methods":["DELETE"],"bindings":{"album":"id"}},"albums.files.create":{"uri":"albums\/{album}\/files\/create","methods":["GET","HEAD"],"bindings":{"album":"id"}},"albums.files.store":{"uri":"albums\/{album}\/files","methods":["POST"],"bindings":{"album":"id"}},"events.index":{"uri":"events","methods":["GET","HEAD"]},"events.create":{"uri":"events\/create","methods":["GET","HEAD"]},"events.store":{"uri":"events","methods":["POST"]},"events.show":{"uri":"events\/{event}","methods":["GET","HEAD"],"bindings":{"event":"id"}},"events.edit":{"uri":"events\/{event}\/edit","methods":["GET","HEAD"],"bindings":{"event":"id"}},"events.update":{"uri":"events\/{event}","methods":["PUT","PATCH"],"bindings":{"event":"id"}},"events.destroy":{"uri":"events\/{event}","methods":["DELETE"],"bindings":{"event":"id"}},"events.files.create":{"uri":"events\/{event}\/files\/create","methods":["GET","HEAD"],"bindings":{"event":"id"}},"events.files.store":{"uri":"events\/{event}\/files","methods":["POST"],"bindings":{"event":"id"}},"files.store.chunk":{"uri":"files\/chunk","methods":["POST"]},"files.destroy":{"uri":"files\/{file}","methods":["DELETE"],"bindings":{"file":"id"}},"files.showConvertForm":{"uri":"files\/{file}\/convert","methods":["GET","HEAD"],"bindings":{"file":"id"}},"files.convert":{"uri":"files\/{file}\/convert","methods":["POST"],"bindings":{"file":"id"}},"search.index":{"uri":"search","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };