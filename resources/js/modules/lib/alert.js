export default {
    actions: {
        SET_ALERT: (ctx, alert) => {
            ctx.commit('UPGRADE_ALERTS', alert);
        },
        SET_ACTIVE_ALERTS({commit, getters}) {
            commit('UPGRADE_ACTIVE_ALERTS');
            return getters.GET_ACTIVE_ALERTS;
        },
        SET_ALERT_HIDDEN: (ctx, alert) => {
            ctx.commit('UPGRADE_ALERT_HIDDEN', alert);
        },
        SET_ALERT_DELETED(ctx, alert) {
            ctx.commit('UPGRADE_ALERT_DELETED', alert);
        }
    },

    mutations: {
        UPGRADE_ALERT_HIDDEN: (state, alert) => {
            for(let i of state.activeAlerts) {
                if(i.massage == alert.massage) {
                    i.show = false;
                    return;
                }
            }
        },
        UPGRADE_ACTIVE_ALERTS: (state) => {
            let new_alert = state.alerts.filter(alert => {
                return !state.activeAlerts.find(active => alert.massage == active.massage);
            });

            if(new_alert) {
                new_alert.map(alert => {
                    if(state.activeAlerts.length > 0) {
                        alert.id = state.activeAlerts[state.activeAlerts.length-1].id + 1;
                    } else {
                        alert.id = 1;
                    }

                    if(alert.show) {
                        state.activeAlerts.push(alert);
                    } else {
                        let index = state.activeAlerts.findIndex(e => e.massage == alert.massage);
                        state.activeAlerts.splice(index, 1);
                    }
                });
            }
        },
        UPGRADE_ALERT_DELETED(state, alert) {
            let index = state.alerts.findIndex(e => e.id == alert.id);
            state.alerts.splice(index, 1);

            let index_active = state.activeAlerts.findIndex(e => e.id == alert.id);
            state.activeAlerts.splice(index_active, 1);
        },
        UPGRADE_ALERTS: (state, alert) => {
            for(let a of state.alerts) {
                if(a.massage === alert.massage) {
                    a.show = alert.show;
                    return;
                }
            }
            state.alerts.push(alert);
        },
    },

    state: {
        alerts: [],
        activeAlerts: [],
    },

    getters: {
        GET_ALERTS(state) {
            return state.alerts;
        },
        GET_ALERT: (state) => (massage) => {
            for(let alert of state.alerts) {
                if(alert.massage == massage) {
                    return alert;
                }
            }
        },
        GET_ACTIVE_ALERTS(state) {
            return state.activeAlerts;
        }
    }
}
