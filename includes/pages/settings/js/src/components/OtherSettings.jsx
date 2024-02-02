import React from 'react';
import {FormGroup, HeadingTwo, HelperText, Label, SingleTextInput} from "@tadamus/wpui";

function OtherSettings(props) {
    return (
        <>
            <HeadingTwo label='Other Settings' />
            <FormGroup>
                <Label htmlFor='admon-excluded-pages' label='Excluded Pages' />
                <SingleTextInput id='admon-excluded-pages' name='admon-excluded-pages' value={ ( admon_settings.excluded_pages ) ? admon_settings.excluded_pages : '' } />
                <HelperText content='Page IDs separated by comma' />
            </FormGroup>
        </>
    );
}

export default OtherSettings;