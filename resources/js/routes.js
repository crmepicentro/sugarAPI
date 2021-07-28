import Client from "./components/Client";
import History from "./components/History";
import Talks from "./components/Talks";
import CarMatch from "./components/CarMatch";
import UsersBlocked from "./components/UsersBlocked";

export const routes = [
        {
            name: '/',
            path: '/ticketsMain/:modulo/:ticket_id/:numero_identificacion',
            component: Client,
            props: true,
            attrs: true
        },
        {
            name: 'client',
            path: '/client/:numero_identificacion',
            component: Client,
            props: true,
            attrs: true
        },
        {
            name: 'tickets',
            path: '/tickets/:numero_identificacion',
            component: History,
            props: true,
            attrs: true
        },
        {
            path: '/talks/:numero_identificacion',
            component: Talks,
            props: true,
            attrs: true
        },
        {
          path: '/carmatch/:ticket_id',
          component: CarMatch,
          props: true,
          attrs: true
        },
        {
          path: '/sugarUserBlocked/',
          component: UsersBlocked,
          props: true,
          attrs: true
        }
];
