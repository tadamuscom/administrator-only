import React from 'react';
import {CheckBox, FormGroup, HeadingTwo, HelperText, Label, SingleTextInput} from "@tadamus/wpui";

function RestApi(props) {
    return (
        <>
            <HeadingTwo label='Rest API' />
            <FormGroup extraClass='tada-bottom-margin'>
                <CheckBox label='Enable REST API Redirection' id='admon-rest-api' name='admon-rest-api' value={ ( admon_settings.rest_api === 'true' ) } />
            </FormGroup>
            <FormGroup>
                <Label htmlFor='admon-rest-api-link' label='Rest API Redirect URL' />
                <SingleTextInput id='admon-rest-api-link' name='admon-rest-api-link' value={ ( admon_settings.rest_api_link ) ? admon_settings.rest_api_link : '' } />
                <HelperText content='The web address to which non-administrators will be redirected to when they try to access the REST API of your site.' />
            </FormGroup>
            <FormGroup>
                <Label htmlFor='admon-excluded-routes' label='Allowed Routes' />
                <SingleTextInput id='admon-excluded-routes' name='admon-excluded-routes' value={ ( admon_settings.excluded_routes ) ? admon_settings.excluded_routes : '' } />
                <HelperText content='Route slugs separated by comma of the pages that the protection should not be applied on.' />
            </FormGroup>
        </>
    );
}

export default RestApi;