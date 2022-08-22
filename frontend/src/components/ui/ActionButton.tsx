import React, {FC} from 'react';
import {Button} from "@mui/material";


interface ButtonProps {
    text: string,
    action: (params: any) => any,
    mr?: number
}

const ActionButton: FC<ButtonProps> = ({text, action, mr}) => {
    return (
        <Button
            onClick={action}
            variant="contained"
            sx={{
                mr: mr || 0,
                color: "black",
                backgroundColor: "#fb8c00",
                borderRadius: 12,
                '&:hover': {
                    color: "white",
                    backgroundColor: "primary.light",
                },
            }}
        >
            {text}
        </Button>
    );
};

export default ActionButton;