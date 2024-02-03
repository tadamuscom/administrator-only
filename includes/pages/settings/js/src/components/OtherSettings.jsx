import React from 'react';
import {CheckBox, FormGroup, HeadingTwo, HelperText, Label, SingleTextInput} from "@tadamus/wpui";

function OtherSettings(props) {
    return (
        <>
            <HeadingTwo label='Other Settings' />
            <FormGroup extraClass='tada-bottom-margin'>
                <CheckBox label='Delete all data on deactivation' id='admon-delete-data' name='admon-delete-data' value={ ( admon_settings.delete_data === 'true' ) } />
            </FormGroup>
        </>
    );
}

export default OtherSettings;