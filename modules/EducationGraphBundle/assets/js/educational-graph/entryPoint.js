// import '@coreui/coreui/dist/css/coreui.min.css';

import React from 'react';
import ReactDOM from 'react-dom';

import { Provider } from 'react-redux';
import { store } from './redux/store/store.js';

import EducationalGraphApp from './EducationalGraphApp.js';

ReactDOM.render(
    <Provider store={store}>
        <EducationalGraphApp />
    </Provider>,
    document.getElementById('educational-graph-app'));