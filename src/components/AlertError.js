import React from "react";

const AlertError = ({ errorMessages }) => {
  const errors = {
    message: errorMessages ? "Dados Incorretos" : "",
    errors: errorMessages ? errorMessages : {},
  };

  const renderErrors = (errors) => {
    const errorItems = Object.keys(errors.errors).map((key, i) => {
      const error = errors.errors[key][0];
      return (
        <li key={key} style={{ color: "red" }}>
          {error}
        </li>
      );
    });

    return <ul>{errorItems}</ul>;
  };

  return (
    <div style={{ marginTop: 2 }}>
      {errors.message}
      <br />
      {renderErrors(errors)}
    </div>
  );
};

export default AlertError;
