import React from 'react';
import {CheckBox, FormGroup, HeadingTwo, HelperText, Label, SingleTextInput} from "@tadamus/wpui";

function FrontEnd( props ) {
    return (
        <>
            <HeadingTwo label='Front End' />
            <FormGroup extraClass='tada-bottom-margin'>
                <CheckBox label='Enable Front-End Redirection' id='admon-front-end' name='admon-front-end' value={ ( admon_settings.front_end === 'true' ) } />
            </FormGroup>
            <FormGroup>
                <Label htmlFor='admon-front-end-link' label='Front-End Redirect URL' />
                <SingleTextInput id='admon-front-end-link' name='admon-front-end-link' value={ ( admon_settings.front_end_link ) ? admon_settings.front_end_link : '' } />
                <HelperText content='The web address to which non-administrators will be redirected to when they try to access the front end of your site.' />
            </FormGroup>
            <FormGroup>
                <Label htmlFor='admon-excluded-pages' label='Allowed Pages' />
                <SingleTextInput id='admon-excluded-pages' name='admon-excluded-pages' value={ ( admon_settings.excluded_pages ) ? admon_settings.excluded_pages : '' } />
                <HelperText content='Page IDs separated by comma of the pages that the protection should not be applied on.' />
            </FormGroup>
        </>
    );
}

export default FrontEnd;