import { usePage } from "@inertiajs/vue3";

export function can(permission) {
    const page = usePage();

    const permissions = page.props.auth.user.permissions ?? [];

    return permissions.includes(permission);
}
