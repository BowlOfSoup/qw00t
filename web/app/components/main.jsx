import React from 'react';
import { Switch, Route } from 'react-router-dom';
import Home from './home.jsx';
import Register from './register/register.jsx';
import Login from './login/login.jsx';

class Main extends React.Component{
  render() {
    return(
      <div className="app-wrap">
        <Switch>
          <Route exact path='/home' component={Home}/>
          <Route exact path='/register' component={Register}/>
          <Route exact path='/login' component={Login}/>
        </Switch>
      </div>
    )
  }
}

export default Main;
