import React, {createContext} from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import Auth from "./store/auth";
import Lots from "./store/lots";

interface Store {
    auth: Auth,
    lots: Lots
}

const auth = new Auth();
const lots = new Lots();

export const Context = createContext<Store>({
    auth,
    lots
})

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);
root.render(
  <React.StrictMode>
    <Context.Provider value={{
        auth,
        lots
    }}>
        <App />
    </Context.Provider>
  </React.StrictMode>
);