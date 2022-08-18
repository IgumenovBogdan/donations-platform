import React, {createContext} from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import Auth from "./store/auth";

interface Store {
    auth: Auth
}

const auth = new Auth();

export const Context = createContext<Store>({
    auth
})

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);
root.render(
  <React.StrictMode>
    <Context.Provider value={{
        auth
    }}>
        <App />
    </Context.Provider>
  </React.StrictMode>
);