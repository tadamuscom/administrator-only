import React from 'react';
import { FormGroup, Button } from '@tadamus/wpui';

function SettingsForm(props) {
    return (
        <div>
            <form onSubmit={ props.onSubmit } id='tada-settings-form'>
                <FormGroup extraClass="tada-form-submit">
                    <Button label="Save Settings" />
                    <p id='tada-status' className='tada-hidden'></p>
                </FormGroup>
            </form>
        </div>
    );
}

export default SettingsForm;