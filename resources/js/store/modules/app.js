import storage from '../../storage'

const state = {
    sidebar: {
        opened: !+storage.get('sidebarStatus'),
    },
    device: 'desktop',
    size: storage.get('size') || 'medium',
    theme: storage.get('theme') || 'bd-light-blue'
}

const mutations = {
    TOGGLE_SIDEBAR: state => {
        state.sidebar.opened = !state.sidebar.opened;
        if (state.sidebar.opened) {
            storage.set({'sidebarStatus': 0})
        } else {
            storage.set({'sidebarStatus': 1})
        }
    },
    CLOSE_SIDEBAR: (state, withoutAnimation) => {
        storage.set({'sidebarStatus': 1});
        state.sidebar.opened = false
    },
    TOGGLE_DEVICE: (state, device) => {
        state.device = device
    },
    SET_SIZE: (state, size) => {
        state.size = size
        storage.set('size', size)
    },
    CHANGE_THEME: (state, theme) => {
        state.theme = theme
        storage.set('theme', theme)
    }
}

const actions = {
    toggleSideBar({commit}) {
        commit('TOGGLE_SIDEBAR')
    },
    closeSideBar({commit}) {
        commit('CLOSE_SIDEBAR')
    },
    toggleDevice({commit}, device) {
        commit('TOGGLE_DEVICE', device)
    },
    changeTheme({commit}, theme) {
        commit('CHANGE_THEME', theme)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
