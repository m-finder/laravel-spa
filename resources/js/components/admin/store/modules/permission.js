import { baseRouters } from '../../router/routers'

const permission = {
  state: {
    // 静态路由
    routers: baseRouters,
    // 动态路由
    addRouters: [],
    elements: []
  },
  mutations: {
    SET_ROUTERS: (state, routers) => {
      // 动态路由
      state.addRouters = routers;
      // 全路由：静态路由 + 动态路由
      state.routers = baseRouters.concat(routers)
    },
    SET_ELEMENTS: (state, elements) => {
      state.elements = elements
    }
  },
  actions: {
    // 生成全部路由
    GenerateRoutes({ commit }, data) {
      return new Promise(resolve => {
        commit('SET_ROUTERS', data)
        resolve()
      })
    },
    GenerateElements({ commit }, data) {
      return new Promise(resolve => {
        commit('SET_ELEMENTS', data.localHash)
        resolve()
      })
    }
  }
}

export default permission
