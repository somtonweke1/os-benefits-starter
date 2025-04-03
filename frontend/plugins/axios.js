export default function ({ $axios, store }) {
  $axios.onRequest(config => {
    if (store.state.auth.token) {
      config.headers.Authorization = `Bearer ${store.state.auth.token}`
    }
    return config
  })

  $axios.onError(error => {
    if (error.response?.status === 401) {
      store.dispatch('auth/logout')
    }
    return Promise.reject(error)
  })
} 