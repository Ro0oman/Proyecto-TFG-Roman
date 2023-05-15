module.exports={
    devServer:{
    proxy:'https://store.steampowered.com/'
},
publicPath: process.env.NODE_ENV === 'production'
? 'http://144.24.201.231/Proyecto-TFG-Roman/vue/'
: ''
}

