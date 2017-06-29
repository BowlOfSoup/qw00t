import React from 'react';
import Main from './main.jsx';
import Header from './header.jsx';

class App extends React.Component{
  render() {
    return(
      <div>
        <Header />
        <Main />
      </div>
    )
  }
}

export default App;
