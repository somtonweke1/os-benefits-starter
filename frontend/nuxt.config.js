export default {
  // Nuxt.js modules
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth-next'
  ],

  // Axios module configuration
  axios: {
    baseURL: 'http://localhost:8000',
    credentials: true
  },

  // Auth module configuration
  auth: {
    strategies: {
      local: {
        token: {
          property: 'token',
          required: true,
          type: 'Bearer'
        },
        user: {
          property: 'user'
        },
        endpoints: {
          login: { url: '/api/login', method: 'post' },
          logout: { url: '/api/logout', method: 'post' },
          user: { url: '/api/user', method: 'get' }
        }
      }
    }
  },

  // Build Configuration
  build: {
    transpile: [
      'defu'
    ]
  }
} 