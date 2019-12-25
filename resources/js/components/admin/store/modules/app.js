import storage from '../../utils/storage'

const state = {
    sidebar: {
        opened: !+storage.get('sidebarStatus'),
    },
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
    OPEN_SIDEBAR: (state)=>{
        storage.set({'sidebarStatus': 0});
        state.sidebar.opened = true
    },
    CHANGE_THEME: (state, theme) => {
        storage.set({'theme': theme});
        state.theme = theme

    }
};

const actions = {
    toggleSideBar({commit}) {
        commit('TOGGLE_SIDEBAR')
    },
    openSideBar({commit}) {
        commit('OPEN_SIDEBAR')
    },
    changeTheme({commit}, theme) {
        commit('CHANGE_THEME', theme)
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
