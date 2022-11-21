import React, {FC, useContext} from 'react';
import {observer} from "mobx-react-lite";
import {Context} from "../index";
import OrganizationAccount from "../components/authorized/OrganizationAccount";
import ContributorAccount from "../components/authorized/ContributorAccount";

const Account: FC = (): React.ReactElement | null => {

    const {auth} = useContext(Context);

    if (auth.user.role === 'organization') {
        return <OrganizationAccount />
    }

    if (auth.user.role === 'contributor') {
        return <ContributorAccount />
    }

    return null;
};

export default observer(Account);