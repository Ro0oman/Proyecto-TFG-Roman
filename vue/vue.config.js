module.exports={
    devServer:{
        proxy:'https://store.steampowered.com/'
    },
    publicPath: process.env.NODE_ENV === 'production'
    ? '/'
    : ''
}