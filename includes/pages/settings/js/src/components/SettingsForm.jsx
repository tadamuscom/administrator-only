import React from 'react';
import {FormGroup, Button} from '@tadamus/wpui';
import FrontEnd from "./FrontEnd";
import RestApi from "./RestAPI";
import OtherSettings from "./OtherSettings";

function SettingsForm( props ) {
    return (
        <div>
            <form onSubmit={ props.onSubmit } id='tada-settings-form'>
                <FrontEnd />
                <RestApi />
                <OtherSettings />
                <FormGroup extraClass="tada-form-submit">
                    <Button label="Save Settings" />
                    <p id='tada-status' className='tada-hidden'></p>
                </FormGroup>
            </form>
        </div>
    );
}

export default SettingsForm;