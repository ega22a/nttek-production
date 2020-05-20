function multipleSelect(_id = "") {
    if (_id.length != 0) {
        var _return = [];
        for (children of document.getElementById(_id).children)
            if (children.selected)
                _return.push(children.value);
        return _return;
    } else
        return false;
}

function makeRandomString(length) {
   var result           = '',
   characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
   charactersLength = characters.length;
   for ( var i = 0; i < length; i++ )
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   return result;
}
