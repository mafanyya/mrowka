// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  modules: [
    '@nuxtjs/strapi',
    '@sidebase/nuxt-auth'
  ],
  auth: {
    baseURL: 'http://localhost:8000/',
    provider:{
      type: 'refresh',
      // refreshOnlyToken: true,

      endpoints:{
        signIn: {path: 'api/login', method: 'post'},
        signOut: {path: 'api/logout', method: 'post'},
        signUp: {path: 'api/register', method: 'post'},
        getSession: {path: 'api/users/me', method: 'post'},
        refresh: {path: 'api/refresh', method: 'post'}
      },
      token: {
        maxAgeInSeconds: 60 + 5,
        signInResponseTokenPointer: '/token',
        sameSiteAttribute: 'lax'
      },
      refreshToken: {
        maxAgeInSeconds: 2592000,
        signInResponseRefreshTokenPointer: '/refreshToken'
      }


    },
  },
  devtools: { enabled: true },
  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8000'

    }
  },

  pages: true,
  css:['~/assets/css/main.css'],
  ssr:false





})
