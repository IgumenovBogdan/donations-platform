import {Alert, AlertColor, Slide} from '@mui/material';
import useAlert from '../../hooks/useAlert';

const AlertPopup = () => {
    const { text, type } = useAlert();

    let isPopup = !!(text && type);

    if (text && type) {
        return (
            <Slide direction="right" in={isPopup} mountOnEnter unmountOnExit>
                <Alert
                    severity={type as AlertColor}
                    sx={{
                        position: 'absolute',
                        zIndex: 10,
                        m: 3
                    }}
                >
                    {text}
                </Alert>
            </Slide>
        );
    } else {
        return <></>;
    }
};

export default AlertPopup;