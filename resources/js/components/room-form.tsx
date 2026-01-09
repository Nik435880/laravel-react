import { Button } from '@/components/ui/button';
import { Form } from '@inertiajs/react';
import { User } from '@/types';

export function RoomForm({ user }: { user: User }) {
    return (
        <Form
            action="/rooms"
            method="POST"
            transform={(data) => ({ ...data, name: user.name })}
        >
            <Button variant="outline">Send message</Button>
        </Form>
    );
}
