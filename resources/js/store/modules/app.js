import storage from '../../storage'

const state = {
  sidebar: {
    opened: storage.get('sidebarStatus') ? !!+storage.get('sidebarStatus') : true,
  },
  device: 'desktop',
  size: storage.get('size') || 'medium'
}

const mutations = {
  TOGGLE_SIDEBAR: state => {
    state.sidebar.opened = !state.sidebar.opened
    if (state.sidebar.opened) {
        storage.set('sidebarStatus', 1)
    } else {
        storage.set('sidebarStatus', 0)
    }
  },
  CLOSE_SIDEBAR: (state, withoutAnimation) => {
      storage.set('sidebarStatus', 0)
    state.sidebar.opened = false
  },
  TOGGLE_DEVICE: (state, device) => {
    state.device = device
  },
  SET_SIZE: (state, size) => {
    state.size = size
      storage.set('size', size)
  }
}

const actions = {
  toggleSideBar({ commit }) {
    commit('TOGGLE_SIDEBAR')
  },
  closeSideBar({ commit }) {
    commit('CLOSE_SIDEBAR')
  },
  toggleDevice({ commit }, device) {
    commit('TOGGLE_DEVICE', device)
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
