// import './styles/app.css'
import React from 'react';
import ReactDOM from 'react-dom/client';
import ListHabitations from './react/controllers/ListHabitations.jsx';
// import { registerReactControllerComponents } from '@symfony/ux-react';


const rootElement = document.getElementById('ListHabitations');
if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);

    root.render(
        <React.StrictMode>
            <ListHabitations />
        </React.StrictMode>
    );
}