from rest_framework import generics, status
from rest_framework.response import Response
from django.contrib.auth.models import User
from django.contrib.auth import authenticate
from rest_framework_simplejwt.tokens import RefreshToken
from .serializers import UserSerializer, LoginSerializer

class RegisterView(generics.CreateAPIView):

    def post(self, request, *args, **kwargs):
        data = request.data
        
        username = data.get('username')
        password = data.get('password')
        role = data.get('role')
        
        if not all([username, password, role]):
            return Response({'error': 'Username, password, and role are required.'}, status=status.HTTP_400_BAD_REQUEST)
        
        user, created = User.objects.update_or_create(
            username=username,
            defaults={'password': password, 'role': role}
        )
        
        user.set_password(password)
        user.save()

        return Response({
            'message': 'User created/updated successfully',
            'user_id': user.id,
            'created': created
        }, status=status.HTTP_201_CREATED if created else status.HTTP_200_OK)






        # self.perform_create(serializer)

class LoginView(generics.GenericAPIView):
    serializer_class = LoginSerializer

    def post(self, request, *args, **kwargs):
        serializer = self.get_serializer(data=request.data)
        serializer.is_valid(raise_exception=True)
        user = authenticate(username=serializer.validated_data['username'], password=serializer.validated_data['password'])
        
        if user:
            refresh = RefreshToken.for_user(user)
            return Response({
                'refresh': str(refresh),
                'access': str(refresh.access_token),
            })
        else:
            return Response({'error': 'Invalid Credentials'}, status=status.HTTP_401_UNAUTHORIZED)
