import React from 'react';

class InputComponent extends React.Component{
  render() {
    return(
      <div className="input_wrap">
        <label htmlFor={this.props.name}>{this.props.label}</label>
        <input
          label={this.props.label}
          value={this.props.value}
          onChange={this.props.onChange}
          name={this.props.name}
          type={this.props.type ? this.props.type : 'text'}
          >
        </input>
      </div>
    )
  }
}

export default InputComponent;
