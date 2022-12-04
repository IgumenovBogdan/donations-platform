import React, {createContext} from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import Auth from "./store/auth";
import Lots from "./store/lots";
import OrganizationAccount from "./store/organizationAccount";
import ContributorAccount from "./store/contributorAccount";
import {AlertProvider} from "./contexts/AlertContext";

interface Store {
    auth: Auth,
    lots: Lots,
    organizationAccount: OrganizationAccount,
    contributorAccount: ContributorAccount
}

const auth = new Auth();
const lots = new Lots();
const organizationAccount = new OrganizationAccount();
const contributorAccount = new ContributorAccount();

export const Context = createContext<Store>({
    auth,
    lots,
    organizationAccount,
    contributorAccount
})

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);
root.render(
  <React.StrictMode>
    <Context.Provider value={{
        auth,
        lots,
        organizationAccount,
        contributorAccount
    }}>
        <AlertProvider>
            <App />
        </AlertProvider>
    </Context.Provider>
  </React.StrictMode>
);