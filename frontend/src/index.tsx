import React, {createContext} from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import Auth from "./store/auth";
import Lots from "./store/lots";
import StatisticsOrganization from "./store/statisticsOrganization";
import StatisticsContributor from "./store/statisticsContributor";

interface Store {
    auth: Auth,
    lots: Lots,
    statisticsOrganization: StatisticsOrganization,
    statisticsContributor: StatisticsContributor
}

const auth = new Auth();
const lots = new Lots();
const statisticsOrganization = new StatisticsOrganization();
const statisticsContributor = new StatisticsContributor();

export const Context = createContext<Store>({
    auth,
    lots,
    statisticsOrganization,
    statisticsContributor
})

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);
root.render(
  <React.StrictMode>
    <Context.Provider value={{
        auth,
        lots,
        statisticsOrganization,
        statisticsContributor
    }}>
        <App />
    </Context.Provider>
  </React.StrictMode>
);