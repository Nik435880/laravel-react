import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import { Form } from '@inertiajs/react';
import DeleteUser from '@/components/delete-user';
import HeadingSmall from '@/components/heading-small';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import { type User } from '@/types';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

export default function Profile({
    mustVerifyEmail,
    status,
}: {
    mustVerifyEmail: boolean;
    status?: string;
    user: User;
}) {
    const { auth } = usePage<SharedData>().props;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Profile settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall
                        title="Profile information"
                        description="Update your name and email address"
                    />

                    <Form
                        action="/settings/profile"
                        method="patch"
                        encType="multipart/form-data"
                        className="space-y-6"
                    >
                        <div className="grid gap-2">
                            <Label htmlFor="name">Name</Label>

                            <Input
                                id="name"
                                type="text"
                                name="name"
                                className="mt-1 block w-full"
                                placeholder="Full name"
                                defaultValue={auth.user.name}
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="email">Email address</Label>

                            <Input
                                id="email"
                                type="email"
                                name="email"
                                className="mt-1 block w-full"
                                defaultValue={auth.user.email}
                                placeholder="Email address"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="avatar">Avatar</Label>

                            <Input
                                id="avatar"
                                name="avatar"
                                type="file"
                                className="mt-1 block w-full"
                            />
                        </div>

                        {mustVerifyEmail && auth.user.email_verified_at === null && (
                            <div>
                                <p className="text-muted-foreground -mt-4 text-sm">
                                    Your email address is unverified.{' '}
                                    <Link
                                        href={route('verification.send')}
                                        method="post"
                                        as="button"
                                        className="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                    >
                                        Click here to resend the verification email.
                                    </Link>
                                </p>

                                {status === 'verification-link-sent' && (
                                    <div className="mt-2 text-sm font-medium text-green-600">
                                        A new verification link has been sent to your email address.
                                    </div>
                                )}
                            </div>
                        )}

                        <div className="flex items-center gap-4">
                            <Button>Save</Button>
                        </div>
                    </Form>
                </div>

                <DeleteUser />
            </SettingsLayout>
        </AppLayout>
    );
}
